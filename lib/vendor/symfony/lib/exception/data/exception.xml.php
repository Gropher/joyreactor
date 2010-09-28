<? echo sprintf('<?xml version="1.0" encoding="%s" ?>', sfConfig::get('sf_charset', 'UTF-8'))."\n" ?>
<error code="<? echo $code ?>" message="<? echo $text ?>">
  <debug>
    <name><? echo $name ?></name>
    <message><? echo htmlspecialchars($message, ENT_QUOTES, sfConfig::get('sf_charset', 'UTF-8')) ?></message>
    <traces>
<? foreach ($traces as $trace): ?>
        <trace><? echo $trace ?></trace>
<? endforeach; ?>
    </traces>
  </debug>
</error>
