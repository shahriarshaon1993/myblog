<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-keypad icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Categories</div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <button @click="addModal=true" type="button" class="btn-shadow btn btn-info">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-plus fa-w-20"></i>
                            </span>
                            Add category
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Active Users</div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Tag name</th>
                                <th class="text-center">Created at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center text-muted">01</td>
                                <td>Laravel</td>
                                <td class="text-center">11:02PM 2 july 2021</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tag adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add category"
                    :mask-closable="false"
                    :closable="false"
                    >

                    <Input placeholder="Enter category name"/>
                    <div class="my-3">
                        <Upload
                            ref="uploads"
                            type="drag"
                            :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg','jpeg','png']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            action="/app/category-file-upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                        <div class="demo-upload-list" v-if="data.iconImage">
                            <img :src="`/uploads/${data.iconImage}`">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                            </div>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary">Add category</Button>
                    </div>

                </Modal>

            </div>
        </div>
    </div>
</template>

<script>

export default ({
    data() {
        return {
            data: {
                categoryName: '',
                iconImage: ''
            },
            token: '',
            addModal: false
        }
    },

    methods: {
        handleSuccess (res, file) {
            this.data.iconImage = res
        },

        handleError (res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            });
        },

        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },

        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },

        async deleteImage() {
            let image = this.data.iconImage
            this.data.iconImage = ''
            this.$refs.uploads.clearFiles()
            const res = await this.callApi('post', 'app/delete-category-image', {imageName: image})
            if(res.status != 200) {
                this.data.iconImage = image
                this.swr()
            }
        }
    },

    async created() {
        this.token = window.Laravel.csrfToken
    }
})

</script>
