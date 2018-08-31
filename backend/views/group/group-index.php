<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/group/group-index' }">Group</el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='content'>
    <div class='m-40-0 p20 base-box-shadow bg-white'>
      <div class='flex jc-end mb-20'>
        <!-- <el-button type="primary" @click='showDialog("create")'>Create Group</el-button> -->
        <el-input
          class='form-search'
          placeholder="Group Name"
          prefix-icon="el-icon-search"
          v-model="form.search">
        </el-input>
      </div>
      <table class='table table-bordered'>
        <thead>
          <th>Group ID</th>
          <th>Group Name</th>
          <th>Operation</th>
        </thead>
        <tbody is='transition-group' name='list'>
          <tr v-for='(item, index) in handleList' :key='item.id'>
            <td v-text='item.id'></td>
            <td v-text='item.group_name'></td>
            <td>
              <div class='flex jc-around'>
                <span class='icon el-icon-setting color_primary' @click='showDialog("edit", item)'></span>
                <el-switch
                  v-model="item.status"
                  active-value="1"
                  inactive-value="2"
                  @change='updateGroupStatus($event, item)'
                  >
                </el-switch>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- dialog -->
      <el-dialog
      title="权限控制"
      :visible.sync="dialogVisible">
        <div class='flex column'>
          <template v-if='dialogType === "create"'>
            <el-input class='transfer-input mb-20' v-model="create.name" placeholder="Group Name"></el-input>
            <el-select class='transfer-input mb-20' v-model="create.available" placeholder="请选择">
              <el-option
                v-for="item in create.options"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </template>
          <div class='flex'>
            <el-transfer
              filterable
              :filter-method="filterMethod"
              filter-placeholder="请输入权限名称"
              v-model="dialogData.choiceList"
              :data="dialogData.list">
            </el-transfer>
          </div>
        </div>
        <span slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="updateForm">提 交</el-button>
        </span>
      </el-dialog>
    </div>
  </div>
</div>
<script>
  new Vue({
    el: '.app',
    data: {
      create: {
        name: '',
        available: '',
        options: []
      },
      dialogType: null,
      dialogVisible: false,
      dialogData: {
        bus: {},
        list: [],
        choiceList: []
      },
      form: {
        search: '',
        list: []
      }
    },
    mounted () {
      var vm = this
      this.csrf = document.querySelector('#spp_security').value
      $.ajax({
        url: '/admin/group/index',
        type: 'post',
        data: {
          dsp_security_param: vm.csrf
        },
        success: function (result) {
          vm.form.list = result
        }
      })
    },
    computed: {
      handleList () {
        var vm = this
        return  this.form.list.filter(function (ele) {
          return ele.group_name.toLowerCase().indexOf(vm.form.search.toLowerCase()) !== -1
        })
      }
    },
    methods: {
      updateGroupStatus (e, item) {
        var vm = this
        var ajaxData = {
          group_id: item.id,
          status: e
        }
        $.ajax({
          url: '/group/update-group-status',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            if (result.status === 1) {
              vm.$message({
                message: result.info,
                type: 'success'
              })
            } else {
              vm.$message.error(result.info)
            }
          }
        })
      },
      showDialog (type, item) {
        var vm = this
        this.dialogVisible = true
        this.dialogType = type
        vm.dialogData.bus = {}
        vm.dialogData.list = []
        vm.dialogData.choiceList = []
        if (type === 'edit') {
          var ajaxData = {
            group_id: item.id
          }
          $.ajax({
            url: '/group/get-group-prev',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status === 1) {
                vm.dialogData.bus = item
                vm.dialogData.list = result.data.all
                vm.dialogData.choiceList = result.data.group
              }
            }
          })
        }
      },
      filterMethod (query, item) {
        return item.label.indexOf(query) > -1;
      },
      updateForm () {
        var vm = this
        if (this.dialogType === 'create') {
          if (this.create.name && this.create.available) {
            this.dialogVisible = false
            this.$message({
              message: 'create success',
              type: 'success'
            })
          } else {
            this.$message.error('create error')
          }
        }
        if (this.dialogType === 'edit') {
          var ajaxData = {
            dsp_security_param: vm.csrf,
            group_id: vm.dialogData.bus.id,
            prev: vm.dialogData.choiceList
          }
          $.ajax({
            url: '/group/add-group-prev',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status === 1) {
                vm.dialogVisible = false
                vm.$message({
                  message: result.info,
                  type: 'success'
                })
              } else {
                vm.$message.error(result.info)
              }
            }
          })
        }
      }
    }
  })
</script>