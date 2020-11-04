<template>
  <div class="hello">
    <h1>erfahrungsberichte</h1>
    <div class="filter">
      <ul>
        <li class="tag">neu</li>
        <li class="tag">oeffentlich</li>
        <li class="tag">troll</li>
        <li><label for="search">suche:</label> <input id="search"/></li>
      </ul>
    </div>
    <div class="report">
      <span class="name">Meji</span>
      <span class="what"></span>
      <span class="when"></span>
      <span class="where"></span>
      <span class="teaser"></span>
      <span class="createdAt">erstellt am 2. okt '20</span>
      <span class="status">in bearbeitung</span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";

export default defineComponent({
  setup() {
    return {
      msg: String,
      reports: [{
        name: 'yay'
      }],
    }
  }
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="stylus">
h3
  margin 40px 0 0
  text-decoration underline

ul
  list-style-type none
  padding 0

li
  display inline-block
  margin 0 10px

.filter li
  padding 0.2em .6em
  &.tag
    border 1px solid
    cursor pointer
</style>
