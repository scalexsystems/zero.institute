<template>
<settings-box title="Institute Details" subtitle="About the institute, Contact info, logo" :withHeader="false">

    <template slot="settings-body">
        <div class="container py-1">
           <div class="text-xs-center">
             <photo-holder class="group-preview-photo" name="file"
                      :dest="`school/logo`"
                      @uploaded="logoUpdated">
            <img :src="institute.logo" class="group-preview-photo">
            </photo-holder>
            </div>
            <div class="institute-details-about">
                <div class="text-xs-center col-xs-12"> ABOUT THE INSTITUTE </div>
                <div class="row institute-details-form">
                <div class="col-xs-12 col-lg-12">
                    <input-text title="Name of the institute" required placeholder="enter here" v-model="institute.name" :feedback="errors.name"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6 ">
                    <input-text title="Institute Username" required placeholder="enter here" v-model="institute.username" :feedback="errors.username"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Institute Email" required placeholder="enter here" v-model="institute.email" :feedback="errors.email"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6 ">
                    <input-text title="University" required placeholder="enter here" v-model="institute.university" :feedback="errors.university"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Institute Type" required placeholder="enter here" v-model="institute.institute_type" :feedback="errors.institute_type"></input-text>
                </div>
                <div class="institute-details-actions col-xs-12 col-lg-6">
                    <div class="btn btn-default" role="button"> Cancel </div>
                    <div class="btn btn-primary" role="button" @click="saveInstitute"> Save </div>
                </div>
              </div>
            </div>

            <div class="institute-details-contact">
            <div class="text-xs-center"> INSTITUTE CONTACT INFORMATION </div>
            <div class="row institute-details-form">
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Address Line 1" required placeholder="enter here" v-model="contact.address_line1" :feedback="errors.address_line1"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Address Line 2" required placeholder="enter here" v-model="contact.address_line2" :feedback="errors.address_line2"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Landmark" v-model="contact.landmark" placeholder="enter here" :feedback="errors.landmark"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="City" required placeholder="enter here" v-model="contact.city" :feedback="errors.city"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="PIN Code" required placeholder="enter here" v-model="contact.pin_code" :feedback="errors.pin_code"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Website" placeholder="enter here" v-model="contact.website" :feedback="errors.website"></input-text>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <input-text title="Fax Number" required placeholder="enter here" v-model="contact.fax" :feedback="errors.fax"></input-text>
                </div>

                <div class="institute-details-actions col-xs-12 col-lg-8">
                    <div class="btn btn-default" role="button" > Cancel </div>
                    <div class="btn btn-primary" role="button" @click="saveContact"> Save </div>
                </div>
            </div>
        </div>
        </div>
    </template>
</settings-box>

</template>
<script lang="babel">
import pick from 'lodash/pick';
import SettingsBox from './SettingsBox.vue';
import PhotoHolder from '../components/ProfilePhotoUploader.vue';

export default{
  created() {
    this.$http.get('school')
      .then(response => response.json())
      .then((response) => {
        this.institute = pick(response, Object.keys(this.institute));
        this.institute.username = response.slug;
        this.contact.website = response.website;
        this.contact.fax = response.fax;
        if (response.address) {
          this.contact = pick(response.address, Object.keys(this.contact));
          this.contact.city = response.address.city.name;
        }
      });
  },
  data() {
    return {
      loaded: false,
      institute: {
        name: '',
        username: '',
        email: '',
        university: '',
        institute_type: '',
        logo: '',
      },
      contact: {
        address_line1: '',
        address_line2: '',
        landmark: '',
        city: '',
        pin_code: '',
        website: '',
        fax: '',
      },
      errors: {},
      logo_id: undefined,
    };
  },
  computed: {
  },
  components: { SettingsBox, PhotoHolder },
  methods: {
    saveInstitute() {
      this.$http.put('school', { ...this.institute })
        .then(() => {
        });
    },
    saveContact() {
      this.$http.put('school', { ...this.contact })
        .then(() => {
        });
    },
    logoUpdated(src, response) {
      this.institute.push({ logo_id: response.body.id });
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../styles/methods";
@import "../styles/variables";
.institute-details {
  &-actions {
    padding: rem(20px) 0;
  }
  &-form {
    padding: rem(40px) 0;
  }
   &-contact{
    padding: rem(20px) 0;
  }
}

.btn-default {
  border: 1px solid $gray-light;
}

.btn {
  margin: 0 rem(10px);
  width: rem(100px);
}


</style>
