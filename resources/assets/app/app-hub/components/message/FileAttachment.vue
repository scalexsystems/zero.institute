<template>
  <div class="card file-attachment" role="button">
     <div class="file-attachment-logo">
         <i class="fa fa-fw" :class="[getClassFor(attachment.extension)]"></i>
     </div>
      <div class="file-attachment-meta" @click="downloadFile">
          <div class="file-attachment-filename">
            <span v-if="attachment.title">{{ attachment.title }}</span>
            <span v-else>{{  attachment.filename }}</span>
          </div>
          <div class="file-attachment-size">
              <small class='text-muted'>{{ attachment.size | forHumans }}</small>
          </div>
      </div>
  </div>
</template>
<script lang="babel">
import filesize from 'filesize';

export default{
  data() {
    return { };
  },
  props: {
    attachment: {
      type: Object,
      required: true,
    },
  },
  methods: {
    downloadFile() {
      const path = this.attachment.path || '#';
      window.open(path);
    },
    getClassFor(ext) {
      switch (ext) {
        case 'webp':
        case 'tiff':
        case 'bmp':
        case 'svg':
        case 'jpeg':
        case 'jpg':
        case 'gif':
        case 'png': return 'fa-picture-o';
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
  },
  filters: {
    forHumans(value) {
      return filesize(value);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../../styles/variables";
@import '../../../styles/methods';
@import '../../../styles/mixins';

.file-attachment {
   padding: rem(12px) rem(12px);
   display: inline-flex;
   flex-direction: row;

   width: 100%;

   @include media-breakpoint-up(md) {
     width: 280px;
   }

   margin: .5rem .5rem .5rem 0;

   &-meta {
     overflow-x: hidden;
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

.fa-picture-o, .fa-file-word-o { color: blue; }
.fa-file-excel-o { color: green; }
.fa-file-powerpoint-o, .fa-file-pdf-o { color: red; }
.fa-file-text-o, .fa-file-o { color: gray; }
</style>
