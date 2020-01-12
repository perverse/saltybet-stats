<template>
    <v-row justify="center">
        <v-col xl="10">
            <matches-table></matches-table>
        </v-col>
    </v-row>
</template>

<script>
    import MatchesTable from '@/components/cards/MatchesTable'

    export default {
        components: {
            'matches-table': MatchesTable
        },

        mounted() {
        }
    }
</script>
