import Fastify from 'fastify'
import cors from 'fastify-cors'
import {getDb} from './src/database'
import {Report, ReportStatus} from './src/entity/Report'
import {User} from './src/entity/User'
import {Not, FindConditions, ILike} from 'typeorm'
import * as _ from 'lodash'
import fastifyStatic from 'fastify-static'
import * as path from 'path'

const staticDir = process.env.NODE_ENV === 'production' ?
  path.join(__dirname, 'public') :
  path.join(__dirname, '..', 'web', 'dist')

const fastify = Fastify({logger: true})
fastify.register(cors)
fastify.register(fastifyStatic, {
  root: staticDir
})

type IReportQuery = {
  search: string,
  status: ReportStatus,
}

type ILoginQuery = {
  user_login: string
  pass: string
}

fastify.get('/user', async (_req, _res) => {
  // TODO get user id from session
  const db = await getDb()
  const person = await db.getRepository( User).findOne();
  const {user_email, user_nicename, user_url} = person
  return {user_email, user_nicename, user_url}
})

fastify.post<{Body: ILoginQuery}>('/login', async (req, _res) => {
  const {user_login, pass} = req.body
  const dbase = await getDb()
  const user = await dbase.getRepository(User).findOne({user_login})
  return {ok: 'ok'}
})

fastify.post<{Body: Partial<Report>, Params: {id: string}}>('/report/:id', async (req, _res) => {
  const db = await getDb()
  const update = _.omit(req.body, 'id')
  if (update.status === ReportStatus.OK) {
    update.published = true
  } else if (update.status) {
    update.published = false
  }
  const report = await db.getRepository(Report).update(req.params.id, update)
  return report
})

fastify.get<{Querystring: IReportQuery}>('/reports', async (req, res) => {
  const {query} = req
  const db = await getDb()

  let where: FindConditions<Report>[]
  const status = query.status || Not(ReportStatus.TROLL)
  if (query.search) {
    where = [{
      status, text: ILike(`%${query.search}%`)
    }, {
      status, name: ILike(`%${query.search}%`)
    }]
  } else {
    where = [{status}]
  }

  const reports = await db.getRepository(Report).find({
    where,
    order: {
      created_at: 'DESC'
    }
  })
  res.type('application/json').code(200)
  return {
    reports
  }
})

fastify.listen(process.env.PORT || 3000, '0.0.0.0', (err, address) => {
  if (err) throw err
  fastify.log.info(`server listening on ${address}`)
})
