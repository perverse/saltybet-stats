<template>
  <v-card
    class="ma-3 pa-3"
    width="480"
    v-if="!loading && character.matches">
    <v-card-title>{{ character.name }} ({{character.winrate}}%)<v-spacer></v-spacer>Tier {{tier}}</v-card-title>
    <v-divider class="mx-4"></v-divider>
    <v-card-text>
      <div>
        <v-chip pill>
          <v-avatar
            left
            color="black"
          >
            <span style="color: white;">{{character.total}}</span>
          </v-avatar>
          Total
        </v-chip>
        <v-chip pill>
          <v-avatar
            left
            color="green"
          >
            <span style="color: white;">{{character.wins}}</span>
          </v-avatar>
          Wins
        </v-chip>
        <v-chip pill>
          <v-avatar
            left
            color="red"
          >
            <span style="color: white;">{{character.losses}}</span>
          </v-avatar>
          Losses
        </v-chip>
      </div>
    </v-card-text>
    <v-card-actions @click="showMatches = !showMatches" class="actions">
      <b class="last-title">Last 15</b>
      <v-spacer></v-spacer>
      <v-btn
        icon
      >
        <v-icon>{{ showMatches ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
      </v-btn>
    </v-card-actions>
    <v-expand-transition>
      <div v-show="showMatches">
        <v-divider></v-divider>
        <v-card-text>
          <div v-for="match in character.matches" v-bind:key="match.id">
            <span :class="[{ win: isWin(match) }, { loss: !isWin(match) }, { result: true }]">{{winOrLoss(match)}}</span> | <span>{{otherCharacter(match)}}</span>
          </div>
        </v-card-text>
      </div>
    </v-expand-transition>
  </v-card>
</template>

<style lang="scss" scoped>
  .result {
    width: 18px;
    display: inline-block;
  }
  .win {
    font-weight: 800;
  }
  .actions {
    cursor: pointer;

    .last-title {
      padding-left: 10px;
    }

    &:hover {
      .last-title {
        color: grey;
      }
    }
  }
</style>

<script>
import CharacterService from '@/services/CharacterService'
import _ from 'lodash'

export default {
  props: ['characterId'],
  data () {
    return {
      character: {},
      loading: true,
      showMatches: false
    }
  },
  computed: {
    tier () {
      return this.character.matches[this.character.matches.length - 1].tier
    }
  },
  mounted () {
    
  },
  async created () {
    this.character = await CharacterService.find(this.characterId, { matches: 0 }).then((data) => {
      this.loading = false;
      return data.data;
    })
  },
  methods: {
    otherCharacter (match) {
      return (this.character.id == match.character_a.id) ? match.character_b.name : match.character_a.name;
    },
    isWin (match) {
      return this.character.id == match.winner.id;
    },
    winOrLoss (match) {
      return (this.isWin(match)) ? 'W' : 'L';
    }
  },
}
</script>