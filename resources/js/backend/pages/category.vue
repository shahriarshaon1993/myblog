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
                                <th>Icon image</th>
                                <th>Tag name</th>
                                <th class="text-center">Created at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(category,i) in categoryList" :key="i" v-if="categoryList.length">
                                <td class="text-center text-muted">{{ i+1 }}</td>
                                <td class="text-center">
                                    <img :src="category.iconImage" width="120">
                                </td>
                                <td>{{ category.categoryName }}</td>
                                <td class="text-center">{{ category.created_at }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btn-sm" @click="showEditModel(category, i)">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Category adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add category"
                    :mask-closable="false"
                    :closable="false"
                    >

                    <Input v-model="data.categoryName" placeholder="Enter category name"/>
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
                            <img :src="`${data.iconImage}`">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                            </div>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...' : 'Add category' }}</Button>
                    </div>

                </Modal>

                <!-- Category edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit category"
                    :mask-closable="false"
                    :closable="false"
                    >

                    <Input v-model="editData.categoryName" placeholder="Enter category name"/>
                    <div class="my-3">
                        <Upload
                            v-show="isIconImageNew"
                            ref="editDataUploads"
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
                        <div class="demo-upload-list" v-if="editData.iconImage">
                            <img :src="`${editData.iconImage}`">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                            </div>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="closeEditModel">Close</Button>
                        <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...' : 'Update Category' }}</Button>
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
            addModal: false,
            isAdding: false,
            categoryList: [],
            editModal: false,
            editData: {
                categoryName: '',
                iconImage: ''
            },
            index: -1,
            isIconImageNew: false,
            isEditingItem: false
        }
    },

    methods: {
        handleSuccess (res, file) {
            res = `/uploads/${res}`
            if(this.isEditingItem){
                return this.editData.iconImage = res
            }
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

        async addCategory() {
            if(this.data.categoryName.trim()=='') return this.error('Category name is requried')
            if(this.data.iconImage.trim()=='') return this.error('Icon image is requried')
            // upload image full path
            this.data.iconImage = `${this.data.iconImage}`
            const res = await this.callApi('post', 'app/create-category', this.data)

            if(res.status === 201) {
                this.categoryList.unshift(res.data)
                this.success('Category has been added successfully')
                this.addModal = false
                this.data.categoryName = ''
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            }else {
                if(res.status === 422) {
                    if(res.data.errors.categoryName) {
                        this.error(res.data.errors.categoryName[0])
                    }
                    if(res.data.errors.iconImage) {
                        this.error(res.data.errors.iconImage[0])
                    }
                }else {
                    this.swr()
                }
            }
        },

        async editCategory() {
            if(this.editData.categoryName.trim()=='') return this.error('Category name is requried')
            if(this.editData.iconImage.trim()=='') return this.error('Icon image is requried')
            const res = await this.callApi('post', 'app/edit-category', this.editData)

            if(res.status === 200) {
                this.categoryList[this.index].categoryName = this.editData.categoryName
                this.success('Category has been updated successfully')
                this.editModal = false
            }else {
                if(res.status === 422) {
                    if(res.editData.errors.categoryName) {
                        this.e(res.editData.errors.categoryName[0])
                    }
                    if(res.editData.errors.iconImage) {
                        this.e(res.editData.errors.iconImage[0])
                    }
                }else {
                    this.swr()
                }
            }
        },

        showEditModel(category, index) {
            let obj = {
                id: category.id,
                categoryName: category.categoryName,
                iconImage: category.iconImage
            }
            this.editData = obj
            this.editModal = true,
            this.index = index,
            this.isEditingItem = true
        },

        async deleteImage(isAdd = true) {
            let image
            if(!isAdd) {
                this.isIconImageNew = true
                image = this.editData.iconImage
                this.editData.iconImage = ''
                this.$refs.editDataUploads.clearFiles()
            }else {
                image = this.data.iconImage
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            }
            const res = await this.callApi('post', 'app/delete-category-image', {imageName: image})
            if(res.status != 200) {
                this.data.iconImage = image
                this.swr()
            }
        },

        closeEditModel()
        {
            this.isEditingItem = false
            this.editModal = false
        }
    },

    async created() {
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', 'app/get-category')
        if(res.status === 200) {
            this.categoryList = res.data
        }else {
            this.swr()
        }
    }
})

</script>
