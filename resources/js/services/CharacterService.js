import axios from 'axios';

class CharacterService {
    constructor() {
        this.baseUrl = '/api/characters'
    }

    async fetch(params) {
        return axios.get(this.baseUrl, {
            params: params
        }).then((data) => {
            return data.data
        });
    }
}

export default new CharacterService()