<template>
  <div class="card" style="width: 18rem;">
    <img :src="data.img" class="card-img-top" alt="..." />
    <div class="card-body">
      <h5 class="card-title">{{ data.name }}</h5>
      <p class="card-text">{{ data.price }}</p>
      <router-link :to="data.link" class="btn btn-primary">Go somewhere</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductCard",

  props: {
    data: { default: null }
  }
};
</script>
