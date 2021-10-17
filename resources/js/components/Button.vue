<template>
    <button :class="config.class" class="text-bold btn btn-sm" :type="config.type">{{config.text}}</button>
</template>
 
<script>
    export default {
        data() {
            return {
                campaign: {}
            }
        },
        props:['config']
    }
</script>