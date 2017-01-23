<template>
  <div class="file-uploader-wrapper">
    <input type="file" name="files" ref="files" @change="onFileSelected" multiple hidden>

    <modal :show="uploading" :dismissable="false">
      <div class="card mb-0">
        <h5 class="card-header text-primary py-2">Uploading</h5>
        <div class="card-block">
          <progress class="progress mb-0" :value="progress" max="100">
            <div class="progress">
              <span class="progress-bar" :style="{ width: progress + '%' }"></span>
              <span class="text-xs-center">Uploading...</span>
            </div>
          </progress>
        </div>
      </div>
    </modal>

    <modal ref="info" :dismissable="false">
      <div class="card mb-0">
        <h5 class="card-header bg-white text-primary py-2">About the files</h5>

        <div class="card-block">
          <template v-for="(title, index) of titles">
            <div v-if="index === 0" class="form-group">
              <label for="file-uploader-1">Name of the file</label>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw" :class="[getClassFor(index)]"></i>
                </span>
                <input type="text" v-model="titles[index]" class="form-control" id="file-uploader-1">
              </div>
            </div>
            <div class="form-group" v-else>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw" :class="[getClassFor(index)]"></i>
                </span>
                <input type="text" v-model="titles[index]" class="form-control" id="file-uploader-1">
              </div>
            </div>
          </template>

          <input-textarea class="mt-2" title="Add a message (optional)" v-model="message"></input-textarea>
        </div>
        <div class="card-footer bg-white pt-2 pb-1">
          <a role="button" class="btn btn-secondary btn-cancel" tabindex @click="onCancel">Cancel</a>
          <a role="button" class="btn btn-primary" tabindex @click="onUpload">Share</a>
        </div>
      </div>
    </modal>
  </div>
</template>
<script type='babel'>
import toArray from 'lodash/toArray';
import Modal from './Modal.vue';

export default{
  props: {
    dest: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      default: 'file',
    },
  },
  components: { Modal },
  data() {
    return {
      uploading: false,
      progress: 0,
      partials: [],
      count: 0,
      errors: [],
      results: [],
      handler: null,
      index: 0,
      titles: [],
      message: '',
    };
  },
  created() {
     this.$on('upload', () => {
       const input = $(this.$refs.files);
       input.replaceWith(input.val('').clone(true));
       input.click();
     });
  },
  methods: {
    onFileSelected(event) {
      const files = event.target.files;

      if (!files.length) return;

      this.uploading = false;
      this.count = files.length;
      this.progress = 0;
      this.partials = [];
      this.errors = [];
      this.results = [];

      this.errors[files.length - 1] = undefined;

      this.$refs.info.$emit('show');

      let start = null;

      const chain = new Promise((resolve) => {
        start = resolve;
      });

      chain.then(() => this.getFileMeta(toArray(files)))
           .then((uploads) => Promise.all(uploads.map(meta => this.upload(meta))))
           .then(() => {
             this.uploading = false;

             this.$emit('uploaded', this.results, this.errors);
           })
           .catch(error => error);

      start()
    },
    getFileMeta(files) {
      const uploads = files.map((file, index) => {
        const payload = new FormData();
        const filename = file.name;

        payload.append(this.name, file);
        this.message = '';

        return { index, payload, filename };
      });

      this.titles = uploads.map(({filename}) => filename);

      return new Promise((resolve, reject) => {

        this.handler = (state) => {
          if (state) {
            uploads[0].message = this.message;

            this.titles.forEach((title, index) => {
              if (uploads[index].filename !== title) {
                uploads[index].payload.append('title', title);
              }
            });

            resolve(uploads);
          } else {
            reject({ message: 'User cancelled upload.' });
          }
        };
      });
    },
    upload({ payload, index, filename, message }) {
      this.uploading = true;

      return this.$http.post(this.dest, payload, {
          progress: (event) => {
            if (event.lengthComputable) {
              this.updateProgress(event.loaded / event.total * 100, index);
            }
          },
        })
        .then(response => response.json())
        .then((result) => {
          this.results[index] = { message, originalFilename: filename, ...result };
        })
        .catch((response) => {
          response.json()
            .then((result) => {
              this.errors[index] = {
                message: result.errors[this.name],
                payload,
                dest: this.dest,
                name: this.name,
              };
            })
            .catch(() => {
              this.errors[index] = {
                message: `Failed to upload: ${filename}`,
                payload,
                dest: this.dest,
                name: this.name,
              };
            });
        });
    },
    onCancel() {
      this.$refs.info.$emit('hide');
      if (this.handler) {
        setTimeout(() => this.handler(false), 0);
      }
    },
    onUpload() {
      if (this.handler) {
        this.$refs.info.$emit('hide');
        setTimeout(() => this.handler(true), 0);
      }
    },
    updateProgress(item, index) {
      this.partials[index] = item;

      this.progress = this.partials.reduce((r, c) => r + (c || 0), 0) / this.count;
    },
    getClassFor(index) {
      const file = this.$refs.files.files[index];

      switch (this.getExtension(file)) {
        case 'webp':
        case 'tiff':
        case 'bmp':
        case 'svg':
        case 'jpeg':
        case 'jpg':
        case 'gif':
        case 'png': return 'fa-file-picture-o';
        case '7z':
        case 'gz':
        case 'tar':
        case 'rar':
        case 'zip': return 'fa-file-zip-o';
        case 'rtf':
        case 'odt':
        case 'pages':
        case 'doc':
        case 'docx': return 'fa-file-word-o';
        case 'ods':
        case 'numbers':
        case 'xls':
        case 'csv':
        case 'xlsx': return 'fa-file-excel-o';
        case 'odp':
        case 'keynote':
        case 'ppt':
        case 'pptx': return 'fa-file-powerpoint-o';
        case 'eps':
        case 'ps':
        case 'pdf': return 'fa-file-pdf-o';
        case 'txt': return 'fa-file-text-o';
        default: return 'fa-file-o';
      }
    },
    getExtension(file) {
      if (!file) return null;

      return file.name.split('.').pop().toLowerCase();
    },
  },
};

</script>
<style lang="scss" scoped>
@import "../styles/variables";
@import "../styles/methods";

.file-upload-wrapper {
  position: relative;
}

.btn-cancel {
  margin-right: .5rem;
}
</style>
