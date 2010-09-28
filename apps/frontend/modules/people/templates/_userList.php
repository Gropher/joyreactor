<?if(!isset($compact)) $compact = false; ?>
<? if(count($users)): ?>
    <table>
      <tbody>
        <? foreach ($users as $user): ?>
            <tr><? include_partial('people/user', array('user' => $user, 'compact' => $compact)) ?></tr>
        <? endforeach; ?>
      </tbody>
    </table>
<? else: ?>
	<i><? echo __('никого нет'	) ?></i>
<? endif; ?>