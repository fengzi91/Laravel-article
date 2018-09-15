<template>
<div>
<md-button @click="submit" class="md-primary md-raised">Open Snackbar</md-button>

    <md-snackbar :md-position="position" :md-duration="duration" :md-active.sync="showSnackbar" md-persistent>
      <span>Connection timeout. Showing limited messages!</span>
      <md-button class="md-primary" @click="showSnackbar = false">Retry</md-button>
    </md-snackbar>
</div>

</template>

<script>
export default {
  name: 'SnackbarExample',
  data: () => ({
    showSnackbar: false,
    position: 'center',
    duration: 4000,
    isInfinity: false
  }),
  methods: {
    submit () {
        this.showSnackbar = true;
    }
  }
}
</script>