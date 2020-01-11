<template>
    <v-row>
        <v-col>
            <characters-table></characters-table>
        </v-col>
    </v-row>
</template>

<script>
    import CharactersTable from '@/components/cards/CharactersTable'

    export default {
        components: {
            'characters-table': CharactersTable
        },

        mounted() {
        }
    }
</script>
