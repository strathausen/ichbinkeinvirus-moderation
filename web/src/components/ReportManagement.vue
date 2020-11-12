<template lang="pug">
.report-page
  h1 erfahrungsberichte
  .main
    .left
      .filter
        .search
          label(for='search') suche:&nbsp;
          input#search(v-model='search')
        ul
          li.tag(:class='{active: status === "in_review"}' @click='status = "in_review"') neu
          li.tag(:class='{active: status === "ok"}' @click='status = "ok"') freigeschaltet
          li.tag(:class='{active: status === "troll"}' @click='status = "troll"') troll
      hr
      .report-row(v-for='report in reports' :key='report.id')
        .report-preview(@click='selectedReport = report' :class='{selected: selectedReport && report.id === selectedReport.id}')
          div.info
            span.date {{report.created_at}}&nbsp/&nbsp
            span.name {{report.name}}&nbsp
          .teaser(v-html='report.teaser||report.text')
    .report-edit(v-if='selectedReport')
      div
        span.dropdown {{labels[selectedReport.status] || selectedReport.status}} ▾&nbsp
          .dropdown-content
            .dropdown-items
              .dropdown-item(:class="{active: selectedReport.status === 'in_review'}" @click='() => onStatusChange("in_review")') neu
              .dropdown-item(:class="{active: selectedReport.status === 'ok'}" @click='() => onStatusChange("ok")') freigeschaltet
              .dropdown-item(:class="{active: selectedReport.status === 'troll'}" @click='() => onStatusChange("troll")') troll
        | / 
        | {{selectedReport.created_at}} / 
        | {{selectedReport.found_solution ? 'loesung gefunden: ' + selectedReport.found_solution : 'keine loesung gefunden'}} / 
        | {{selectedReport.reported ? '' : 'nicht '}}gemeldet / 
        | {{selectedReport.email}}
      div
        | passiert wo: {{selectedReport.happened_where || '-'}} / passiert am: {{selectedReport.happened_at || '-'}}
      hr
      div: b teaser:
      .report-teaser(v-html='selectedReport.teaser' contenteditable @blur='onTeaserEdit')
      hr
      div: b {{selectedReport.name}} schrieb:
      .report-text(v-html='selectedReport.text' contenteditable @blur='onTextEdit')
</template>

<script lang="ts">
import { defineComponent, reactive, ref, watch } from "vue"
import axios from 'axios'
import moment from 'moment'
import useAsyncState from '../compose/useAsyncState'
import { DateTime } from 'luxon'
import _ from 'lodash'

type Report = {
  id: number
  name: string
  text: string
  happened_at: string
  happened_where: string
  trigger_warning: boolean
  teaser: string
  created_at: string
  published: boolean
  reported: boolean
  found_solution: boolean
  email: string
  ip_address: string
  status: string
}
type ReportResponse = {
  reports: Report[]
}

export default defineComponent({

  setup() {
    const search = ref('')
    const status = ref('in_review')
    const selectedReport = ref<Report>()

    const editReport = reactive<Partial<Report>>({})
    const labels = {
      in_review: 'neu',
      ok: 'freigeschaltet'
    } 

    const saveReport = useAsyncState(
      async () => {
        if(!selectedReport.value) return;
        return axios.post<ReportResponse>(`/report/${selectedReport.value.id}`, editReport)
      }
    )

    const request = useAsyncState(
      () => axios.get<ReportResponse>('/reports', {params: {
        search: search.value, status: status.value
      }}).then(x => x.data.reports.map(report => {
        report.created_at = DateTime.fromISO(report.created_at).toFormat('dd.MM.yyyy')
        if (report.happened_at) {
          report.happened_at = DateTime.fromISO(report.happened_at).toFormat('dd.MM.yyyy') || report.happened_at
        }
        report.text = report.text
          //.replace(/\r\n/g, '<br/>')
          //.replace(/[\r\n]/g, '<br/>')
          .replaceAll('\\"', '"')
          .replaceAll("\\'", "'")
        if (report.teaser)
          report.teaser = report.teaser
            .replaceAll('\\"', '"')
            .replaceAll("\\'", "'")
        return report
      }))
    )
    request.run()
    watch(search, request.run)
    watch(status, request.run)
    watch(status, () => selectedReport.value = undefined)
    // Reset edit object on select report change
    watch(selectedReport, () => {
      //_.each(editReport, (val, index: string) => delete editReport[index])
      delete editReport.text
      delete editReport.teaser
      delete editReport.status
    })
    watch(editReport, () => {
      if (!selectedReport.value) {
        return
      }
      if (!_.isEmpty(editReport)) {
        //if (editReport.text) {
        //  const text = editReport.text
        //    .replace(/\r\n/g, '<br/>')
        //    .replace(/[\r\n]/g, '<br/>')
        //  _.assign(selectedReport.value, editReport)
        //} else {
          _.assign(selectedReport.value, editReport)
        //}
        saveReport.run()
      }
    })

    return {
      msg: String,
      reports: request.data,
      error: request.error,
      state: request.state,
      search,
      selectedReport,
      status,
      labels,
      editReport,
      onTextEdit(e: any) {
        editReport.text = e.target.innerText
      },
      onTeaserEdit(e: any) {
        editReport.teaser = e.target.innerText
      },
      onStatusChange(status: string) {
        editReport.status = status
      }
    }
  }
})
</script>

<style scoped lang="stylus">
h3
  margin 40px 0 0
  text-decoration underline

ul
  list-style-type none
  padding 0

li
  display inline-block
  margin 0 20px 0 0

.filter li
  padding 0.2em .62em

  &.tag
    border 1px solid
    cursor pointer

  &.active
    background var(--main-color)
    color var(--background-color)
    border-color var(--main-color)

.search
  border-bottom 1px solid
  //margin-right 1em
  input
    width 220px
    

.main
  display flex

.left
  border-right 1px solid
  width 280px
  flex-shrink 0
  padding-bottom 1em

.report-preview
  padding-right 1em
  margin-top 1.2em
  height 4rm
  cursor pointer
  
  &.selected
    box-shadow 0px 2px

  .name, .date
    font-weight bold
  .name
    white-space nowrap
    overflow hidden
    text-overflow ellipsis
  .teaser
    overflow hidden
    text-overflow ellipsis
    display -webkit-box
    white-space pre-line
    -webkit-line-clamp 2
    -webkit-box-orient vertical
  .info
    overflow hidden
    text-overflow ellipsis

.report-edit
  padding-left 1em
  flex-grow 1

  div
    margin-bottom .6em

.main
  flex-grow 1

.report-page
  display flex
  flex-direction column
  flex-grow 1

.report-text, .report-teaser
  white-space pre-line

.dropdown
  display inline-block
  position relative
  &:hover
    .dropdown-content
      display block

.dropdown-content
  position absolute
  display none
  z-index 1
  height 0px
  overflow visible
  .dropdown-items
    padding .4em .6em 0
    background var(--background-color)
    border 1px solid var(--main-color)
    .dropdown-item
      cursor pointer
    .active
      font-weight bold

</style>
