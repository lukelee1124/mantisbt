<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Summary Graph by Resolution
 * @package MantisBT
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */

require_once( 'core.php' );

plugin_require_api( 'core/graph_api.php' );

access_ensure_project_level( config_get( 'view_summary_threshold' ) );

$f_width = gpc_get_int( 'width', 300 );
$t_ar = plugin_config_get( 'bar_aspect' );

$t_token = token_get_value( TOKEN_GRAPH );
if( $t_token == null ) {
	$t_metrics = enum_bug_group( lang_get( 'resolution_enum_string' ), 'resolution' );
} else {
	 $t_metrics = json_decode( $t_token, true );
}

graph_group( $t_metrics, plugin_lang_get( 'by_resolution_mix' ), $f_width, $f_width * $t_ar );
