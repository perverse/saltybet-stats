<template>
  <span v-if="character.id == winnerId" style="font-weight: bold;">{{character.name}} ({{character.winrate}}%)</span>
  <span v-else>{{character.name}} ({{character.winrate}}%)</span>
</template>

<script>
export default {
  props: ['winnerId', 'character']
}
</script>