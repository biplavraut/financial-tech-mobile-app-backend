<template>
  <div class="card">
    <div class="card-body">
      <slot name="actions"></slot>
      <h2 class="card-title" v-html="title"></h2>
      <br />
      <div
        class="loader-container d-flex flex-wrap justify-content-center"
        v-if="$store.getters.cardLoading"
      >
        <div class="overlay__inner">
          <div class="overlay__content">
            <app-loader  :width="10"></app-loader>
          </div>
        </div>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "Card",

  props: {
    title: {
      type: String,
      required: true,
    },
    bodyPadding: {
      type: String,
      default: "15px",
    },
  },
};
</script>

<style scoped>
.card-root {
  position: relative;
  margin-bottom: 20px;
}

.card-title {
  padding: 10px 15px;
  margin: 0;
  font-size: 18px !important;
  font-weight: 400;
  /* background: rgba(255, 255, 255, 0.6);
  color: #666666; */
  border-radius: 15px 15px 0 0;
  border-bottom: 1px solid #cccccc;
}

.card-content {
  background-color: #ffffff;
}

.loader-container {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: fixed;
    background: rgba(237, 237, 237, 0.6);
    z-index: 999;
}

.overlay__inner {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}

.overlay__content {
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>