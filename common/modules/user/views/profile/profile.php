<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?><h1><?php echo UserModule::t('Your profile'); ?></h1>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<table class="dataGrid">
	<tr>
		<th class="label"><?php echo CHtml::encode($user->getAttributeLabel('username')); ?></th>
	    <td><?php echo CHtml::encode($user->username); ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($user->getAttributeLabel('email')); ?></th>
    	<td><?php echo CHtml::encode($user->email); ?></td>
	</tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($user->getAttributeLabel('firstname')); ?></th>
        <td><?php echo CHtml::encode($user->firstname); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($user->getAttributeLabel('lastname')); ?></th>
        <td><?php echo CHtml::encode($user->lastname); ?></td>
    </tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($user->getAttributeLabel('created')); ?></th>
    	<td><?php echo $user->created; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($user->getAttributeLabel('lastvisit')); ?></th>
    	<td><?php echo $user->lastvisit; ?></td>
	</tr>
	<tr>
		<th class="label"><?php echo CHtml::encode($user->getAttributeLabel('status')); ?></th>
    	<td><?php echo CHtml::encode(User::itemAlias("UserStatus",$user->status)); ?></td>
	</tr>
</table>
