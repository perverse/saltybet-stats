<template>
  <v-card>
    <v-card-title>
      Characters
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
        :items="characters"
        :options.sync="options"
        :server-items-length="totalCharacters"
        :loading="loading"
        class="elevation-1"
        :footer-props="footerProps"
    ></v-data-table>
  </v-card>
</template>

<script>
import CharacterService from '@/services/CharacterService';
import _ from 'lodash';

export default {
  data () {
    return {
      totalCharacters: 0,
      characters: [],
      loading: true,
      options: {},
      headers: [
        {
          text: 'Name',
          align: 'left',
          sortable: true,
          value: 'name',
        },
        { text: 'Wins', value: 'wins' },
        { text: 'Losses', value: 'losses' },
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
            this.characters = data.items
            this.totalCharacters = data.total
          })
    }, 500),
  
    async getDataFromApi ({ sortBy, sortDesc, page, itemsPerPage, search }) {
      this.loading = true

      return await CharacterService.fetch({ 
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
          total: data.total
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