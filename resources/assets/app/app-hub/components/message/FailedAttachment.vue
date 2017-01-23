<template>
  <div class="card file-attachment">
     <div class="file-attachment-logo">
         <i class="fa fa-fw" :class="[getClassFor(extension)]"></i>
     </div>
      <div class="file-attachment-meta">
          <div class="file-attachment-filename">{{ filename }}</div>
          <div class="text-danger">
            <span v-if="!uploading">
              <i class="fa fa-fw fa-warning"></i> {{ errorMessage }}
            </span>
          </div>
      </div>
      <div class="file-attachment-retry">
        <a role="button" @click="retry" :disabled="uploading">
          <i v-if="uploading" class="fa fa-fw fa-circle-o-notch fa-spin"></i>
          <i v-else class="fa fa-fw fa-upload"></i>
        </a>
      </div>
  </div>
</template>
<script lang="babel">
export default{
  props: {
    attachment: {
      type: Object,
      required: true,
    },
    messageId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return { uploading: false, error: null };
  },
  computed: {
    extension() {
      const attachment = this.attachment;

      return attachment.payload.get(attachment.name).name.split('.').pop();
    },
    filename() {
      const attachment = this.attachment;

      return attachment.payload.get(attachment.name).name;
    },
    errorMessage() {
      const attachment = this.attachment;
      const error = this.error;

      return String(error || attachment.message);
    },
  },
  methods: {
    getClassFor(ext) {
      switch (ext) {
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
        case 'xlsx': return 'fa-file-excel-o';
        case 'odp':
        case 'keynote':
        case 'ppt':
        case 'pptx': return 'fa-file-powerpoint';
        case 'eps':
        case 'ps':
        case 'pdf': return 'fa-file-pdf-o';
        case 'txt': return 'fa-file-text-o';
        default: return 'fa-file-o';
      }
    },
    retry() {
      if (this.uploading) return;

      this.uploading = true;

      this.attachment.payload.append('message_id', this.messageId);
      this.$http.post(this.attachment.dest, this.attachment.payload)
        .then(response => response.json())
        .then(() => {
          this.error = null;
        })
        .catch((response) => {
          if (response && 'json' in response) {
            response.json().then((result) => {
              this.error = result.errors.file;
            });
          }
        })
        .then(() => {
          this.uploading = false;
        });
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../../styles/variables";
@import '../../../styles/methods';

.file-attachment {
   padding: rem(12px) rem(12px);
   display: inline-flex;
   flex-direction: row;

   width: 280px;

   margin: .5rem .5rem .5rem 0;

   &-meta {
     overflow-x: hidden;
     flex: 1;
   }

   &-logo {
     font-size: 2rem;
     margin-right: .5rem;
   }

   &-filename {
     overflow-x: hidden;
     white-space: nowrap;
     text-overflow: ellipsis;
   }

   &-size {
     display: inline-flex;
   }
}

.fa-file-picture-o, .fa-file-word-o { color: blue; }
.fa-file-excel-o { color: green; }
.fa-file-powerpoint-o, .fa-file-pdf-o { color: red; }
.fa-file-text-o, .fa-file-o { color: gray; }
</style>
