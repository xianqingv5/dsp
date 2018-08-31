<?php
use yii\helpers\Url;
?>
<div class='sidebarBox'>
  <ul class='sidebar-ul'>
    <li class="<?php echo $this->context->id == 'group' ? 'act' : ''; ?>">
      <!-- title -->
      <a class='sidebar-title flex jcsb' href="<?php echo Url::to('/group/group-index')?>">
        <div class='flex'>
          <span class='sidebar-icon'>
            <svg class="icon" aria-hidden="true">
              <use xlink:href="#icon-quanxianguanli"></use>
            </svg>
          </span>
          <span>Group List</span>
        </div>
        <span class='dn sidebar-icon-title-right glyphicon glyphicon-chevron-down'></span>
      </a>
    </li>
    <li class="<?php echo $this->context->id == 'offer' ? 'act' : ''; ?>">
      <!-- title -->
      <a class='sidebar-title flex jcsb' href='<?php echo Url::to('/offer/offer-index') ?>'>
        <div class='flex'>
          <span class='sidebar-icon'>
            <svg class="icon" aria-hidden="true">
              <use xlink:href="#icon-tongzhiguangbo"></use>
            </svg>
          </span>
          <span>Campaigns</span>
        </div>
        <span class='dn sidebar-icon-title-right glyphicon glyphicon-chevron-down'></span>
      </a>
      <!-- con -->
      <!-- <div class='sidebar-con'>
        <div class='sidebar-text flex jc-start'>
          <span class='sidebar-icon-text'>
            <svg class="icon" aria-hidden="true">
              <use xlink:href="#icon-yuanquan"></use>
            </svg>
          </span>
          <span></span>
        </div>
      </div> -->
    </li>
    <li>
      <!-- title -->
      <a class='sidebar-title flex jcsb'>
        <div class='flex'>
          <span class='sidebar-icon'>
            <svg class="icon" aria-hidden="true">
              <use xlink:href="#icon-area_chart"></use>
            </svg>
          </span>
          <span>Report</span>
        </div>
        <span class='dn sidebar-icon-title-right glyphicon glyphicon-chevron-down'></span>
      </a>
    </li>
    <li class="<?php echo $this->context->id == 'user' ? 'act' : ''; ?>">
      <!-- title -->
      <a class='sidebar-title flex jcsb' href="<?php echo Url::to('/user/user-index') ?>">
        <div class='flex'>
          <span class='sidebar-icon'>
            <svg class="icon" aria-hidden="true">
              <use xlink:href="#icon-zhanghuguanli"></use>
            </svg>
          </span>
          <span>Account Management</span>
        </div>
        <span class='dn sidebar-icon-title-right glyphicon glyphicon-chevron-down'></span>
      </a>
    </li>
  </ul>
</div>
