<template>
  <div class="c-hub-message-message-attachment card d-inline-flex flex-row" role="button" @click="$emit('preview')">
     <div class="logo">
         <icon class="fa-fw" :type="icon"></icon>
     </div>
      <div class="main">
          <div class="filename">
            <span>{{ title }}</span>
          </div>
          <div class="size">
            <small class='text-muted'>{{ size }}</small>

            <a class="btn download float-right" role="button" @click.stop.prevent="download" v-tooltip="'Download the file.'">
              <icon type="cloud-download"></icon>
            </a>
          </div>
      </div>
  </div>
</template>

<script>
import filesize from 'filesize'

const ICONS = {
  'picture-o': ['webp', 'tiff', 'bmp', 'svg', 'jpeg', 'jpg', 'gif', 'png'],
  'file-zip-o': ['7z', 'gz', 'tar', 'rar', 'zip'],
  'file-word-o': ['rtf', 'odt', 'pages', 'doc', 'docx'],
  'file-excel-o': ['ods', 'numbers', 'xls', 'xlsx', 'csv', 'tsv'],
  'file-powerpoint-o': ['odp', 'keynote', 'ppt', 'pptx'],
  'file-pdf-o': ['eps', 'ps', 'pdf'],
  'file-text-o': ['txt']
}

const icons = Object.keys(ICONS)
const exts = Object.values(ICONS)

function getIcon (ext) {
  const index = exts.findIndex(any => any.indexOf(ext) > -1)

  if (index > -1) return icons[index]

  return 'file-o'
}

export default {
  name: 'MessageAttachment',

  props: {
    attachment: {
      type: Object,
      required: true
    }
  },

  computed: {
    icon () {
      return getIcon(this.attachment.extension)
    },

    title () {
      const attachment = this.attachment

      return attachment.title || attachment.filename
    },

    size () {
      return filesize(this.attachment.size || 0)
    }
  },

  methods: {
    download () {
      // TODO: Implement it!
    }
  }
}
</script>

<style lang="scss">
@import '../../../styles/methods';

.c-hub-message-message-attachment {
  width: 280px;
  padding: to-rem(12px);
  margin: 10px 10px 0 0;

  overflow-x: hidden;

  .download {
    margin-top: -.5rem;
  }

  .logo {
    font-size: 2rem;
    margin-right: .5rem;
  }

  .filename {
    overflow-x: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .main {
    overflow: hidden;
  }

  .fa-picture-o, .fa-file-word-o { color: blue; }
  .fa-file-excel-o { color: green; }
  .fa-file-powerpoint-o, .fa-file-pdf-o { color: red; }
  .fa-file-text-o, .fa-file-o { color: gray; }
}
</style>
