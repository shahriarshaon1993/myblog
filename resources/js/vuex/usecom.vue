<template>
    <div>
        <h1>Hello, I'm from usecom.</h1>
        <h3 class="text-info">Counter USe: {{ $store.state.counter }}</h3>

        <coma></coma>
        <comc></comc>
        <comc></comc>

        <Button class="mt-3" type="info" @click="changeCounter">Change state of the counter</Button>

    </div>
</template>

<script>
import coma from './coma.vue'
import comb from './comb.vue'
import comc from './comc.vue'

export default {
    data() {
        return {
            //
        }
    },

    methods: {
        changeCounter() {
            this.$store.commit('changeTheCounter', 1)
        }
    },

    components: {
        coma,comb,comc
    }

}
</script>
