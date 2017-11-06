<template>
  <div class="carousel-out">
    <el-carousel indicator-position="inside">
      <el-carousel-item v-for="item in 4" :key="item">
        <!--<h3>{{ item }}</h3>-->
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script>
  import { Carousel, CarouselItem } from 'element-ui'

  export default {
    name: 'mainCarousel',
    components: {
      elCarousel: Carousel,
      elCarouselItem: CarouselItem
    }
  }
</script>

<style scoped>
  .el-carousel__item h3 {
    color: #475669;
    font-size: 18px;
    opacity: 0.75;
    line-height: 300px;
    margin: 0;
  }

  .el-carousel__item:nth-child(4n+1) {
    /*background-color: #8bbfa7;*/
    background-image: url("../../assets/carousel/joanna-kosinska-254405.jpg");
    background-size: cover;
  }

  .el-carousel__item:nth-child(4n+2) {
    /*background-color: #dfe4e6;*/
    background-size: cover;
    background-image: url("../../assets/carousel/freddie-marriage-264214.jpg");
    background-repeat: no-repeat;
    background-position: center center;
  }

  .el-carousel__item:nth-child(4n+3) {
    /*background-color: #4de649;*/
    background-image: url("../../assets/carousel/roman-bozhko-251947.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
  }

  .el-carousel__item:nth-child(4n+4) {
    /*background-color: #8b88e6;*/
    background-image: url("../../assets/carousel/DesktopHDCopy.png");
    background-size: cover;
  }

  .carousel-out {
    width: 100%;
    position: relative;
    display: inline-block;
  }

  .el-carousel /deep/ .el-carousel__container {
    position: relative;
    height: 700px;
  }

</style>
