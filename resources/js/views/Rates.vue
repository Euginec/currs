<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row align-items-start">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Current Rate: {{ currentRates.current_date }}</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">CUR</th>
                                        <th scope="col">BUY</th>
                                        <th scope="col">SALE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(rate, index) in currentRates.rates" :key="index">
                                            <td class="font-weight-bold">{{rate.curr_name}}</td>
                                            <td>{{ rate.buy }}</td>
                                            <td>{{ rate.sale }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                           </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <span class="mr-2">Rates History</span>
                                <input class="mr-2" type="date" v-model="start">
                                <input class="mr-2" type="date" v-model="end">
                                <button class="btn btn-primary btn-sm" @click="getHistory">Update</button>
                            </div>
                            <div class="card-body">
                                 <table class="table" v-if="historyRates.length">
                                    <thead>
                                        <tr>
                                            <th scope="col">DATE</th>
                                            <th scope="col">CUR</th>
                                            <th scope="col">BUY</th>
                                            <th scope="col">SALE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(rate, index) in historyRates" :key="index">
                                            <td class="font-weight-bold">{{rate.curr_date | moment("YYYY-MM-DD")}}</td>
                                            <td class="font-weight-bold">{{rate.curr_name}}</td>
                                            <td>{{ rate.buy }}</td>
                                            <td>{{ rate.sale }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            start: null,
            end: null,
        }
    },
    watch: {
        start: function(value) {
            this.$store.commit('set_period_start', value);
        },
        end: function(value) {
            this.$store.commit('set_period_end', value);
        },
    },

    computed: {
        currentRates: function() { return this.$store.getters.currentRates },
        historyRates: function() { return this.$store.getters.historyRates },
    },

    methods: {
        getHistory() {
            this.$store.dispatch('getHistory');
        }
    },

    created() {
        this.start = this.$moment().format("YYYY-MM-DD"),
        this.end = this.$moment().format("YYYY-MM-DD"),

        this.$store.commit('clear_history_rates');
        this.$store.dispatch('getCurrentRate');
    }
}
</script>
