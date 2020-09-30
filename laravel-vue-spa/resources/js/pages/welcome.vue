<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'home' }">
          {{ $t('home') }}
        </router-link>
      </template>
      <template v-else>
        <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
        </router-link>
        <router-link :to="{ name: 'register' }">
          {{ $t('register') }}
        </router-link>
      </template>
    </div>
    <div>
      <product-card :data="data">

      </product-card>
    </div>
    
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ProductCard from '~/components/ProductCard';

export default {
  layout: 'basic',
  components: {
      ProductCard
  },
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    data: {name: "test", price: 250, link: 'asdasd', img: 'https://scontent.fdac65-1.fna.fbcdn.net/v/t1.0-0/s228x119/72039852_451830778766076_2342229632842989568_n.jpg?_nc_cat=110&_nc_sid=13bebb&_nc_eui2=AeHE51jCIhenQIKdRbxI39O1i99xsR97nQaL33GxH3udBp2pXZtXJTwATmSAgjtm3U9LfBf7TenDcEMTqOp4HPdb&_nc_ohc=na9uQxHI-A0AX8-sw1S&_nc_ht=scontent.fdac65-1.fna&tp=7&oh=c9b59d8493bb64dec6e3ea6393791175&oe=5F97CB33'}
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
