<template>
  <div class="app-container" :style="{
    '--main-color': themeColor.color.fg,
    '--background-color': themeColor.color.bg}">
    <div id="nav">
      <theme-color />
    </div>
    <router-view class="main-container"/>
  </div>
</template>

<script lang="ts">
import _Vue, { defineComponent } from 'vue'
import ThemeColor from './components/ThemeColor.vue'
import { useThemeColors } from './compose/useThemeColors'

export default defineComponent({
  components: {
    'theme-color': ThemeColor,
  },
  setup() {
    const { themeColor } = useThemeColors()
    return { themeColor }
  }
})
</script>

<style lang="stylus">
body
  margin 0

.app-container, a, input, textarea
  color var(--main-color)
  background-color var(--background-color)

#nav
  top 0px
  right 0px
  padding 1em
  position fixed

.app-container
  width 100vw

  .main-container
    max-width 72rem
    margin auto
    height 100vh
    padding 0 1em

.app-container, #app
  height 100vh
  display flex
  align-items stretch

#app
  font-family Avenir, Helvetica, Arial, sans-serif
  -webkit-font-smoothing antialiased
  -moz-osx-font-smoothing grayscale

  input, textarea
    border none
    outline none
    font-size inherit
    background-color inherit
    font-family inherit
    font-size inherit

  textarea
    width 100%
    height auto

  .home
    display flex
    align-items stretch
    flex-grow 1

hr
  color inherit
  border-top none
  border-bottom 1px solid
</style>
