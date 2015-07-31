<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'setco762_novo');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'setco762_user');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'm4r10123#');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '53|EW y},r89J=D |-+|;RqmevW}xtwGZf+6E$}zUm#9scO)x:iCh}{agvpwlg5:');
define('SECURE_AUTH_KEY',  'R:|[AQdUxSn(2lyfIPB7vjMr}7ov|,a+6+~]()<l#aGKmJzO3K:J8k31?]n0GSGf');
define('LOGGED_IN_KEY',    '^(Sn~Y5Hs)wQdd3emDs#6|F3Dr%g{e.CKr7X<Cx_;|u(|1lD503Yffy3LoA;g9q@');
define('NONCE_KEY',        'X(K<D4#~dZ{PDmf3w>xGVu5/ }<WSATMfgB%zI9ckP<{j.fQr.8ZB~4K|7:Xlx9.');
define('AUTH_SALT',        'IJ!BIV`@@FCy7B4|8PvgshqbxwbFZ+<0F1F@aE@|n6Q2?p8+:3a@GFZ[5AOqqGZa');
define('SECURE_AUTH_SALT', 'L~-v]-/<i.NP?bP>by@fiqwk#]`O/a3ovc%P:N(LCtQ&Q{DmH-adJ74zq_!|tVa[');
define('LOGGED_IN_SALT',   '8i*IdO[[|G,8-1FKkkD`gc+5!6>!RT:PyD~||7G5b-J>CV;FF<[|-}Jvp`@TNJ_]');
define('NONCE_SALT',       'zb#MC++cnh7]^>^_<G:)|zQh/%fJ<AqV`h]4Ggy*YA05>C`Km9kK`:DivHo7}GEQ');
define('FS_METHOD', 'direct');
/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
