<template>
  <v-card
    class="mx-auto my-12"
    width="374">
    <v-card-title>{{ character.name }}</v-card-title>
    <v-card-text>
      <v-row
        align="center"
        class="mx-0"
      >
        <v-rating
          :value="character.rating"
          color="amber"
          dense
          half-increments
          readonly
          size="14"
        ></v-rating>

        <div class="grey--text ml-4">({{character.winrate}}%)</div>
      </v-row>

      <div class="my-4 subtitle-1 black--text">
        {{character.tier}} Tier {{character.matches[character.matches.length - 1].tier}}
      </div>
    </v-card-text>
  </v-card>
</template>

<style lang="scss" scoped>

</style>

<script>
import CharacterService from '@/services/CharacterService'
import _ from 'lodash'

export default {
  props: ['characterId'],
  data () {
    return {
      character: {},
      loading: true
    }
  },
  mounted () {
    
  },
  async created () {
    this.character = await CharacterService.find(this.characterId, { matches: 0 }).then((data) => {
      return data.data;
    })
  },
  methods: {

  },
}
</script>