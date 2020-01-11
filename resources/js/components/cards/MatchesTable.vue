<template>
  <v-card>
    <v-card-title>
      Matches
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="matches"
      :options.sync="options"
      :server-items-length="totalMatches"
      :loading="loading"
      class="elevation-1 matches"
      :footer-props="footerProps"
      show-expand
    >
      <template v-slot:expanded-item="{ item }">
        <td colspan="8" style="padding: 0px 16px;">
          <v-container fill-height fluid>
            <v-row no-gutters>
              <v-col cols="12">
                <v-row
                  align="center"
                  justify="center"
                  class="grey lighten-5"
                >
                  <character-summary :character-id="item.character_a.id"></character-summary>
                  <character-summary :character-id="item.character_b.id"></character-summary>
                </v-row>
              </v-col>
            </v-row>
          </v-container>
        </td>
      </template>
      <template v-slot:item.character_a="{ item }">
        <character-slot v-bind:character="item.character_a" v-bind:winner-id="item.winner.id"></character-slot>
      </template>
      <template v-slot:item.character_b="{ item }">
        <character-slot v-bind:character="item.character_b" v-bind:winner-id="item.winner.id"></character-slot>
      </template>
    </v-data-table>
  </v-card>
</template>

<style lang="scss" scoped>
  .matches {
    .v-data-table {
      td {
        height: 36px;
      }
    }
  }
</style>

<script>
import MatchService from '@/services/MatchService'
import CharacterSlot from '@/components/cards/MatchesTable/CharacterSlot'
import CharacterSummary from '@/components/cards/CharacterSummary'
import _ from 'lodash'

export default {
  components: {
    'character-slot': CharacterSlot,
    'character-summary': CharacterSummary
  },
  data () {
    return {
      totalMatches: 0,
      matches: [],
      loading: true,
      options: {},
      headers: [
        {
          text: 'Character A',
          align: 'left',
          sortable: false,
          value: 'character_a',
        },
        {
          text: 'Character B',
          align: 'left',
          sortable: false,
          value: 'character_b',
        },
        { text: 'Tier', value: 'tier' },
        { text: 'Mode', value: 'mode' },
        { text: 'Odds', value: 'odds' },
        { text: 'Fight Length', value: 'time' },
        { text: 'Date', value: 'date' }
      ],
      footerProps: {
        showFirstLastPage: true,
        itemsPerPageOptions: [5, 15, 25, 50, 100]
      },
      search: '',
      debounceGetData: null
    }
  },
  watch: {
    options: {
      handler () {
        this.triggerWatcher();
      },
      deep: true,
    },
    search: {
      handler () {
        this.triggerWatcher();
      }
    }
  },
  mounted () {
  },
  methods: {
    triggerWatcher: _.debounce(function () {
      this.getDataFromApi(this.mergeFilters(this.options))
          .then(data => {
            this.matches = data.items
            this.totalMatches = data.total
          })
    }, 500),
  
    async getDataFromApi ({ sortBy, sortDesc, page, itemsPerPage, search }) {
      this.loading = true

      return MatchService.fetch({ 
        page,
        limit: itemsPerPage,
        sortBy,
        sortDesc,
        filters: {
          search: search
        }
      }).then((data) => {
        this.loading = false

        return {
          items: data.data,
          total: data.meta.total
        }
      })
    },

    mergeFilters (options) {
      return Object.assign({
        search: this.search
      }, options);
    }
  },
}
</script>