<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      right
      :disable-resize-watcher="true"
    >
      <v-list dense>

        <router-link to="/">
          <v-list-item link>
            <v-list-item-action>
              <v-icon>mdi-account-outline</v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>Matches</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>

        <router-link to="/characters">
          <v-list-item link>
            <v-list-item-action>
              <v-icon>mdi-table</v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>Characters</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>

      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="black"
      dark
    >
      <v-spacer />

      <v-toolbar-title>Saltybets Stats</v-toolbar-title>

      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
    </v-app-bar>

    <v-content>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-content>

    <v-footer
      color="black"
      app
    >
      <v-spacer />

      <span class="white--text">&copy; 2019</span>
    </v-footer>
  </v-app>
</template>

<style lang="scss" scoped>
  nav a {
    text-decoration: none;
  }
</style>

<script>
  export default {
    name: 'LayoutsDemosBaselineFlipped',

    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
  }
</script>
