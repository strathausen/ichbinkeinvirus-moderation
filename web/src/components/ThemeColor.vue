<template lang="pug">
.color-square.dropdown(:style="{backgroundColor: themeColor.color.fg, borderColor: themeColor.color.bg}")
  .dropdown-content
    .color-square(
      v-for="color, index in themeColors"
      :style="{backgroundColor: color.fg, borderColor: color.bg}"
      @click="setThemeColor(index)"
      :class="{active: color.fg === themeColor.color.fg }"
    )
</template>

<script lang="ts">
import { computed } from 'vue'
import { useThemeColors } from '../compose/useThemeColors'

export default {
  setup() {
    const { themeColors, setThemeColor, themeColor } = useThemeColors()
    return { themeColor, themeColors, setThemeColor }
  }
}
</script>

<style lang="stylus" scoped>
.dropdown
  margin-right .6em
  display inline-block
  position relative
  top 4px
  &:hover
    .dropdown-content
      display block

.dropdown-content
  position absolute
  display none
  z-index 1
  left -3px
  top -3px

  .color-square
    margin-bottom 1px

.color-square
  border 3px solid
  width 11px
  height 11px
  cursor pointer

  &.active
    box-shadow 0px 0px 0px 1px var(--main-color)

</style>
