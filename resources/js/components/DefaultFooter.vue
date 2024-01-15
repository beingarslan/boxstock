<script setup>
import { RouterLink } from "vue-router";
import { useStore } from 'vuex';
import footerLogo from '../../images/footer-logo.svg';
import footerRightImg from '../../images/footer-Group5.svg';
import logoHear from '../../images/group-logo-hear.png';
import logoHear2 from '../../images/see-all.svg';

const store = useStore();
</script>
<template>
      <footer class="bg-[#000000] pt-[80px]" v-if="store.getters.getLayout !== 'LayoutAdmin'">
        <div class="container">
          <div class="footer-top flex justify-between md:flex-row flex-col">
            <div class="footer-left">
              <img :src="footerLogo" alt="footer-logo" />
              <p class=" flex order-2 text-[#FFFFFF] leading-[18px] tracking-[0.2px] text-[12px] font-[400] font-[Poppins] mt-[17px] max-w-[499px]">
                  Boxstockb2b is ontstaan om de winkels en resselmarkt wat toegankelijker te maken.</p>
              <img :src="footerRightImg" alt="footer-group-logo" class="mt-11 order-3 flex" />
            </div>
            <div class="footer-right">
              <h4 class="font-[Poppins] font-bold text-white leading-[40px] text-[12px] tracking-[0.266667px]  ">Contact
              </h4>
              <p class="text-[white] mt-[12px] text-[12px] font-[400px] font-[Poppins]">info@boxstockb2b.com <br> +31621418306 <br> corkstraat 46, 3047 AC Rotterdam</p>
            </div>
          </div>
        </div>
        <div class="footer-bottom bg-[#fff] mt-[80px] py-[20px]">
          <div class="container">
            <div class="footer-bottom-wrapper flex justify-between md:flex-row flex-col ">
              <p class="text-[#000] text-[14px] font-sm font-[Poppins] leading-8 flex items-center">© 2023 <span
                  class="font-bold font-size-[14px] leading-8 font-[Poppins] ml-[5px]">BOXSTOCKB2B</span>
              </p>
              <img :src="logoHear" alt="gropu-logo-hear" />
            </div>
          </div>
        </div>
      </footer>
      <div  v-if="store.getters.getLayout !== 'LayoutAdmin' && !store.getters.getToken" class="street-wrapper bg-[#fff] block text-right ">
        <div class="street-wear bg-[#00B67A] text-[#fff] inline-block py-[20px] px-[35px] text-[14px] font-bold">
            <RouterLink class="font-[700] text-[18px] leading-[21px] font-[TTCommons]" to="/login">
                <h4 class="uppercase flex items-center text-left mb-0 font-[700] font-[TTCommons] text-[#fff] ">Buy or sell sneakers & streetwear!<img class="ml-[10px]" :src="logoHear2" alt="see all" /></h4>
            </RouterLink>
        </div>
      </div>
</template>
