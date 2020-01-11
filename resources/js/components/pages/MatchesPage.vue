<template>
    <v-row>
        <v-col>
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
