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
          <v-container fill-height fluid :align="'start'">
            <v-row
              :align="'start'"
              :justify="'center'"
              class="lighten-5">
              <v-col cols="12" md="6" xl="4">
                <character-summary :character-id="item.character_a.id"></character-summary>
              </v-col>
              <v-col cols="12" md="6" xl="4">
                <character-summary :character-id="item.character_b.id"></character-summary>
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
      <template v-slot:item.date="{ item }">
        <td>
          {{formatDate(item.date)}}
        </td>
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
import moment from 'moment';

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
    },

    formatDate (datestring) {
      return moment(datestring, "YYYY-MM-DD HH-mm-ss").format("DD-MM-YYYY");
    }
  },
}
</script>