<template>
    <div>
        <h1>Hello, I'm from com C.</h1>
        <h4 class="text-primary">Coutner C: {{ counter }}</h4>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters({
            'counter': 'getCounter'
        })
    },

}
</script>
