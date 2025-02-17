<template>
<div class="file-uploader-wrapper">
  <input type="file" name="files" ref="files" @change="onFileSelected" multiple hidden>

  <modal :open="uploading" :dismissable="false">
    <div class="card mb-0">
      <h5 class="card-header">Uploading</h5>
      <div class="card-block">
        <progress class="progress bg-muted mb-0" :value="progress" max="100" style="width: 100%">
          <div class="progress">
            <span class="progress-bar" :style="{ width: progress + '%' }"></span>
          </div>
        </progress>

        <div class="text-center pt-2">{{ progress.toPrecision(3) }}%</div>
      </div>
    </div>
  </modal>

  <modal ref="info" :dismissable="false">
    <div class="card mb-0">
      <h5 class="card-header bg-white2">About the files</h5>

      <div class="card-block" style="overflow: auto">
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
            <input type="text" v-model="titles[index]" class="form-control">
          </div>
        </div>
        </template>

        <input-textarea class="mt-2" title="Add a message (optional)" v-model="message"></input-textarea>
      </div>
      <div class="card-footer bg-white text-right">
        <a role="button" class="btn btn-secondary btn-cancel" tabindex @click="onCancel">Cancel</a>
        <a role="button" class="btn btn-primary" tabindex @click="onUpload">Share</a>
      </div>
    </div>
  </modal>
</div>
</template>

<script lang='babel'>
import http from '../../vuex/api'

export default{
  props: {
    dest: {
      type: String,
      required: true
    },
    name: {
      type: String,
      default: 'file'
    }
  },

  data: () => ({
    uploading: false,
    progress: 0,
    partials: [],
    count: 0,
    errors: [],
    results: [],
    handler: null,
    index: 0,
    titles: [],
    message: ''
  }),

  methods: {

    async onFileSelected (event) {
      const files = event.target.files

      if (!files.length) return false

      this.uploading = false
      this.count = files.length
      this.progress = 0
      this.partials = []
      this.errors = []
      this.results = []

      this.errors[files.length - 1] = undefined

      this.$refs.info.$emit('open')

      try {
        const uploads = await this.getFileMeta(files)
        await Promise.all(uploads.map(meta => this.upload(meta)))

        this.uploading = false
        this.$emit('uploaded', this.results, this.errors)
      } catch (e) {
        this.$debug(e)
        /* User cancelled the upload. */
      }
    },

    getFileMeta (files) {
      const uploads = []
      for (let index = 0; index < files.length; index += 1) {
        const file = files[index]
        const payload = new window.FormData()
        const filename = file.name
        payload.append(this.name, file)

        uploads.push({ index, payload, filename })
      }

      this.titles = uploads.map(({ filename }) => filename)

      return new Promise((resolve, reject) => {
        this.handler = (state) => {
          if (state) {
            uploads[0].message = this.message
            this.message = ''

            this.titles.forEach((title, index) => {
              if (uploads[index].filename !== title) {
                uploads[index].payload.append('title', title)
              }
            })

            resolve(uploads)
          } else {
            reject({ message: 'User cancelled upload.' })
          }
        }
      })
    },
    async upload ({ payload, index, filename, message }) {
      this.uploading = true

      try {
        const { attachment } = await http.post(true, this.dest, payload, {
          progress: (event) => {
            if (event.lengthComputable) {
              this.updateProgress(event.loaded / event.total * 100, index)
            }
          }
        })

        this.results[index] = { message, originalFilename: filename, ...attachment }
      } catch ({ errors }) {
        this.errors[index] = {
          message: errors.$message || `Failed to upload: ${filename}`,
          payload,
          dest: this.dest,
          name: this.name
        }
      }
    },
    onCancel () {
      this.$refs.info.$emit('close')
      if (this.handler) {
        setTimeout(() => this.handler(false), 0)
      }
    },
    onUpload () {
      if (this.handler) {
        this.$refs.info.$emit('close')
        setTimeout(() => this.handler(true), 0)
      }
    },
    updateProgress (item, index) {
      this.partials[index] = item

      this.progress = this.partials.reduce((r, c) => r + (c || 0), 0) / this.count
    },
    getClassFor (index) {
      const file = this.$refs.files.files[index]

      switch (this.getExtension(file)) {
        case 'webp':
        case 'tiff':
        case 'bmp':
        case 'svg':
        case 'jpeg':
        case 'jpg':
        case 'gif':
        case 'png': return 'fa-file-picture-o'
        case '7z':
        case 'gz':
        case 'tar':
        case 'rar':
        case 'zip': return 'fa-file-zip-o'
        case 'rtf':
        case 'odt':
        case 'pages':
        case 'doc':
        case 'docx': return 'fa-file-word-o'
        case 'ods':
        case 'numbers':
        case 'xls':
        case 'csv':
        case 'xlsx': return 'fa-file-excel-o'
        case 'odp':
        case 'keynote':
        case 'ppt':
        case 'pptx': return 'fa-file-powerpoint-o'
        case 'eps':
        case 'ps':
        case 'pdf': return 'fa-file-pdf-o'
        case 'txt': return 'fa-file-text-o'
        default: return 'fa-file-o'
      }
    },
    getExtension (file) {
      if (!file) return null

      return file.name.split('.').pop().toLowerCase()
    }
  },

  created () {
    this.$on('upload', () => {
      const input = window.jQuery(this.$refs.files)
      input.replaceWith(input.val('').clone(true))
      input.click()
    })
  }
}

</script>
<style lang="scss">
@import "../../styles/variables";
@import "../../styles/methods";

.file-upload-wrapper {
  position: relative;
}

.btn-cancel {
  margin-right: .5rem;
}
</style>
