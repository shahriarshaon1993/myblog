<template>
    <div>
        <h1>Hello, I'm from usecom.</h1>
        <h3 class="text-info">Counter USe: {{ counter }}</h3>

        <coma></coma>
        <comb></comb>
        <comc></comc>

        <Button class="mt-3" type="info" @click="changeCounter">Change state of the counter</Button>

    </div>
</template>

<script>
import coma from './coma.vue'
import comb from './comb.vue'
import comc from './comc.vue'
import {mapGetters} from 'vuex'

export default {
    data() {
        return {
            //
        }
    },

    computed: {
        ...mapGetters({
            'counter': 'getCounter'
        })
    },

    methods: {
        changeCounter() {
            // this.$store.commit('changeTheCounter', 1)
            this.$store.dispatch('changeCounterAction', 1)
        }
    },

    components: {
        coma,comb,comc
    }

}
</script>
