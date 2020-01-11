<template>
  <span v-if="character.id == winnerId" style="font-weight: bold;">{{character.name}}</span>
  <span v-else>{{character.name}}</span>
</template>

<script>
export default {
  props: ['winnerId', 'character']
}
</script>