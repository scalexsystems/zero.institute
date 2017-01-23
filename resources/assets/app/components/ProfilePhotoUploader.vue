<template>
  <div class="profile-photo-uploader" @click="$refs.file.click()">
    <slot></slot>
    <input type="file" ref="file" hidden @change="onFileSelected">

    <div class="backdrop" v-if="cropping">
      <activity-box v-bind="{ title, subtitle }">
        <img :src="image">

        <div class="text-xs-center">
          <button type="button" class="btn btn-primary" @click="cropAndUpload">Crop</button>
        </div>
      </activity-box>
    </div>

    <div class="uploading" v-if="uploading">
      <progress class="progress mb-0" :value="progress" max="100">
        <div class="progress">
          <span class="progress-bar" :style="{ width: progress + '%' }"></span>
        </div>
      </progress>
    </div>

    <div class="overlay" v-if="empty">
      <div class="upload-trigger">
        <div>
          <i class="fa fa-arrow-circle-up fa-3x mt-2 mb-1"></i>
        </div>

        <span>Click to Upload</span>
      </div>
    </div>
  </div>
</template>

<script type='babel'>

export default{
  props: {
    name: {
      type: String,
      default: 'photo',
    },
    dest: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      default: 'Crop Photo',
    },
    subtitle: {
      type: String,
      default: ''
    },
    crop: {
      type: Boolean,
      default: true,
    },
    options: {
      type: Object,
      default () {
        return {
          fixed_size: true,
          mode: 'square',
        };
      },
    },
  },
  data() {
    return {
      cropping: false,
      uploading: false,
      progress: 0,
      error: null,
      context: null,
    };
  },
  computed: {
    empty () {
      const cropping = this.cropping;
      const uploading = this.uploading;

      return !(cropping || uploading);
    },
  },
  methods: {
    cropAndUpload () {
      if (!this.context) return;
    },
    upload (payload) {
      const form = new FormData();

      form.append(this.name, payload);

      this.uploading = true;
      this.progress = 0;
      this.error = null;

      this.$http.post(this.dest, form, {
          progress: (event) => {
            if (event.lengthComputable) {
              this.progress = event.loaded / event.total * 100;
            }
          },
        })
        .then((response) => {
          this.uploading = false;

          const src =  response.headers.get('Location');
          this.$emit('uploaded', src, response);
        })
        .catch((response) => {
          this.uploading = false;

          if ('json' in response) {
            response.json().then((result) => {
              this.error = result.message || 'Upload failed.';
            }).catch((error) => {
              this.error = error;
            });
          } else {
            this.error = response;
          }
        });
    },
    onFileSelected (event) {
      const files = event.target.files;

      if (!files || !files[0]) return;

      return this.upload(files[0]);

      // const ext = file.substring(file.lastIndexOf('.') + 1).toLowerCase();

      // if (['png', 'gif', 'jpg', 'jpeg'].indexOf(ext) < 0) return;

      // const FD = new FileReader();

      // FD.onload((event) => {
        // this.context = new Crop('#profile-photo-uploader-cropper', event.target.result, this.options);
      // });

      // FD.readAsDataURL(selected[0]);
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../styles/variables';

.profile-photo-uploader {
  display: inline-flex;
  position: relative;
  cursor: pointer;
  .overlay {
    opacity: 0;
    background: $gray-lighter;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    transition: opacity .3s;
  }

  &:hover {
    .overlay {
      opacity: 0.95;
    }
  }
}

.upload-trigger {
  display: flex;
  height: 100%;
  flex-direction: column;;

  align-items: center;
  justify-content: center;
}

img, .uploading, .uploading:before {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.uploading {
  &:before {
    content: '';
    opacity: 0.85;
  }

  display: flex;
  height: 100%;
  flex-direction: column;;

  align-items: center;
  justify-content: center;

  padding: 1rem;
  .progress {
    margin-top: 1rem;
    height: .25rem;
    z-index: 1;
  }
}

.round {
  .overlay, .uploading {
    border-radius: 100%;
    overflow: hidden;
  }
}
</style>
