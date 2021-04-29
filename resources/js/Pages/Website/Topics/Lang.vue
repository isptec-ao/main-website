<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "LangTopic",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              topic: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Tópicos'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            name: this.$page.props.topic.name,
            lang: this.$page.props.lang
          }),
        }
        },
        methods: {
            settranslation(id) {
              this.$inertia.put(this.route('canvas.topics.settranslation', id));
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
          <h4 class="mb-0 font-size-18">Tópicos</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.topics.index')" method="get">
                    <i class="bx bx-arrow-back"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Adicionar Translation: {{ $page.props.lang.toUpperCase() }}</h4>

            <!-- Create Topics Form -->
            <b-form @submit.prevent="form.put(route('canvas.topics.settranslation', $page.props.topic.id))">
              <slot />
              <b-form-group label="Nome" label-for="name">
                <b-form-input id="name" type="text" v-model="form.name" :class="{'is-invalid': form.errors.name}"></b-form-input>
                <div v-if="form.errors.name" class="invalid-feedback animated fadeIn">{{form.errors.name}}</div>
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
    </div>
    <!-- end row -->
  </div>
</template>