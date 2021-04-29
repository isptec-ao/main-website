<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "LangMessage",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              message: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Felicitações'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            description: this.$page.props.message.description,
            gender: this.$page.props.message.gender,
            banner: null,
            imagepreview: null,
            lang: this.$page.props.lang,
            _method: 'PUT'
          }),
          options: [
                        { text: 'Ambos', value: 'A' },
                        { text: 'Masculino', value: 'M' },
                        { text: 'Feminino', value: 'F' },
                    ],
        }
        },
        methods: {
            settranslation(id) {
              this.$inertia.put(this.route('canvas.messages.settranslation', id));
          },
          imageSelected(e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.banner ? this.form.banner : new Blob());
              reader.onload = e => {
                this.form.imagepreview = e.target.result ? e.target.result : null;
              }
            },
          downloadAllAttachments () {
                window.open(route('canvas.messages.downloadallattachments') + '?model_id=' + this.$page.post.id);
            },

            downloadSingleAttachment (id) {
                window.open(route('canvas.messages.downloadsingleattachment') + '?model_id=' + id);
            },
            deleteSingleAttachment (id) {
                window.open(route('canvas.messages.deletesingleattachment') + '?model_id=' + id);
            },  
        },
        computed: {

        },
        mounted() {

        },
    }
</script>
<template>
  <div>
      <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Felicitações</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.messages.index')" method="get">
                    <i class="bx bx-arrow-back"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Adicionar Translation: {{ $page.props.lang.toUpperCase() }}</h4>

            <!-- Create Service Categories Form -->
            <b-form @submit.prevent="form.post(route('canvas.messages.settranslation', $page.props.message.id))">
              <slot />
              <b-form-group label="Descrição" label-for="description">
                <b-form-textarea
                  id="description"
                  v-model="form.description"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
            </b-form-group>
            <b-form-group label="Gênero" label-for="gender">
                <b-form-radio-group
                    class="mt-2"
                    id="gender"
                    v-model="form.gender"
                    :options="options"
                    name="gender"
                ></b-form-radio-group>
                <div v-if="form.errors.gender" class="invalid-feedback animated fadeIn">{{form.errors.gender}}</div>
            </b-form-group>
                <b-button type="submit" class="btn btn-rounded" variant="brand" v-if="!form.processing">Registar</b-button>
                <b-button class="btn btn-block btn-rounded" variant="brand" v-if="form.processing">
                    <b-spinner small type="grow"></b-spinner>
                </b-button>
            </b-form>
          </div>
        </div>

      </div>
      <!-- end col -->

      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Imagem</h4>
            <b-form-group label="Image" label-for="image">
            <b-input-group>
                <b-form-file id="image"
                          size="sm"
                          name="image"
                          browse-text="Procurar"
                          v-model="form.banner"
                          placeholder="Escolha uma imagem ou arraste-o aqui"
                          drop-placeholder="Solte a imagem aqui"
                          @input="imageSelected">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.imagepreview = null, form.banner = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
            <b-form-group label="Image Preview" label-for="imagepreview">
              <div class="col-md-5">
                  <img class="rounded" :src="$page.props.message.banner_link && !form.banner ? $page.props.message.banner_link : form.imagepreview" alt="" width="200">
              </div>
            </b-form-group>
            </div>
        </div>  
    </div>
    </div>
    <!-- end row -->
  </div>
</template>