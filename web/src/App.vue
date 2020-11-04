<template>
  <div id="nav">
    <router-link to="/about">login</router-link>
  </div>
  <router-view />
</template>

<style lang="stylus">
body
  background-color #f3f3f4

body, a, input
  color #1c3eb0

#nav
  top 0px
  right 0px
  padding 1em
  position fixed

#app
  max-width 72rem
  margin auto
  font-family Avenir, Helvetica, Arial, sans-serif
  -webkit-font-smoothing antialiased
  -moz-osx-font-smoothing grayscale
  margin-top 30px

  input
    border none
    outline none
    font-size inherit
    background-color inherit
    border-bottom 1px dotted
</style>
