<br><br><br>
<? if ($isCurrent):?>
    <h1>Ваш профайл</h1>
<? else:?>
    <h1><?=$user->firstname;?> <?=$user->lastname;?></h1>
<? endif;?>

    имя:<?=$user->firstname;?><br>
    фамилия:<?=$user->lastname;?><br>
    пол:<?=$user->is_male?'м':'ж';?><br>

<? if ($isCurrent):?>
    <br>
    <a href="/profile/edit">редактировать</a><br>
    <a href="/profile/changepassword">сменить пароль</a><br>
<div id="services">
    Привязать акаунты:<br>
    <?
    $this->widget('ext.eauth.EAuthWidget', array('action' => '/login'));
    ?>
</div>
<script>
    if (userData.userOauth !== undefined) {
        for(service in userData.userOauth)
            $('#services li.'+service).remove();
        if ($('#services li.auth-service').length == 0)
            $('#services').remove();
    }
</script>
<? endif;?>