<template>
  <div class="about">
    <h1>anmelden</h1>
    <form>
      <label>name:</label>
      <input/>
      <label>passwort:</label>
      <input type="password"/>
      <button>anmelden</button>
    </form>
  </div>
</template>

<style lang="stylus" scoped>
form
  width 260px
  margin auto

label
  margin-top 1.8em
  width 100%
  display inline-block

input
  width 100%

button
  display block
  background-color inherit
  color inherit
  font-size inherit
  border 1px solid
  padding 0.2em 0.6em
  margin 1.8em auto
</style>
