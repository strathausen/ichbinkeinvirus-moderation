import {createConnection, Connection} from 'typeorm'
import {User} from './entity/User'
import {Report} from './entity/Report'
import * as dotenv from 'dotenv'

dotenv.config()

let connection: Connection

export async function getDb() {
  if (connection) {
    return connection
  }
  connection = await createConnection({
    type: 'mysql',
    url: process.env.TYPEORM_URL,
    synchronize: false,
    entities: [
      User, Report
    ]
  })
  return connection
}
