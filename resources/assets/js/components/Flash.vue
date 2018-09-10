<template>
    <div class="alert alert-warning alert-flash" role="alert">
        <strong>Success!</strong>{{ body }}
    </div>
 </template>

<script>
    export default {
        props:['message'],
        data(){
            return {
                body : this.message
            }
        }
    };
</script>

<style>
    .alert-flash{
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>