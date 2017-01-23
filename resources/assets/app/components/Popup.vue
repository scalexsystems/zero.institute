<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container" :class="styleClass">
            <div class="modal-header popup-header" v-if="showHeader">
                <slot name="popup-title">
                    {{ title }}
                </slot>
                <div v-if="dismissable">
                  <a class="popup-dismiss" href="#" @click.prevent.stop="$emit('popupClose')">
                    <img src="../assets/cross.svg">
                  </a>
                 </div>
            </div>

            <div class="modal-body">
                <slot name="popup-body"></slot>
            </div>

            <div class="modal-footer" v-if="showFooter">
              <slot name="popup-footer"></slot>
            </div>
        </div>
    </div>
  </transition>
</template>
<script>
export default{
  data() {
    return {
    };
  },
  components: {},
  props: {
    showHeader: {
      type: Boolean,
      default: true,
    },
    showFooter: {
      type: Boolean,
      default: true,
    },
    title: {
      type: String,
      default: '',
    },

    styleClass: {
      type: String,
      default: '',
    },

    dismissable: {
      type: Boolean,
      default: true,
    },
  },

};
</script>
<style lang="scss">
    @import '../styles/methods';
    @import '../styles/variables';

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

 .modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

 .modal-container {
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
  border: 0;
}

.modal-body {
}

.modal-footer {
    text-align: left;
    border: 0;
}


.popup-header {
 text-align: left;
 border: 0;
 display: flex;
 min-width: rem(600px);
}
.popup-dismiss {
   display: flex;
    align-items: center;
    justify-content: center;
    border-radius: $border-radius-sm;
    cursor: pointer;
}

</style>
