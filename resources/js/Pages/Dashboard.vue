<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import Layout from "../layouts/main";
    export default {
        name: "Index",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {

            }
        }, [dashboard]),

        metaInfo: {
            title: 'Dashboard'
        },
        components: {
            
        },
        data () {
            return {
                title: 'Dashboard',
            }
        },
        methods: {
            
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
          <h4 class="mb-0 font-size-18">Dashboard</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item active">Welcome {{ $page.props.user.name }}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->
    <div class="row">
      <div class="col-xl-4">
        
      </div>
      <!-- end col -->
      <div class="col-xl-8">
        <div class="row">
          
        </div>
      </div>
    </div>
    <!-- end row -->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4"></h4>
      
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</template>