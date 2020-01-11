import axios from 'axios';

class MatchService {
    constructor() {
        this.baseUrl = '/api/matches'
    }

    async fetch(params) {
        return axios.get(this.baseUrl, {
            params: params
        }).then((data) => {
            return data.data
        });
    }
}

export default new MatchService()