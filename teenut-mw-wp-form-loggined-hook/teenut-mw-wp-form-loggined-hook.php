<?php
/*
Plugin Name: 鬼目ナット (MW WP Form ログインフック)
Description: MW WP Form にアクセスした際、ログイン中であればフォームの中身を自動入力するプラグイン
Version:     0.0.1
Author:      アルム＝バンド
*/

function teenut_autocomplete_mwform_name( $value, $name ) {
    // ログインしている場合
    if ( is_user_logged_in() ) {
        //項目追加： MW WP Form の name="name" の項目の初期値 value にニックネーム設定 )
        if ( $name === 'name' ) {
            $current_user = wp_get_current_user();
            $value = $current_user->nickname; // ニックネーム（プロパティ名）
        }
    }
    return $value;
}
/**
 * アクションフック
 *
 * `mw-wp-form-xxx` はフックで使用する修飾子。 `xxx`はフォーム識別子として作成したフォームの投稿IDとする
 * ※今回はサンプルなので投稿IDはハードコーディング
 */
add_filter( 'mwform_value_mw-wp-form-xxx', 'teenut_autocomplete_mwform_name', 10, 2 );

function teenut_autocomplete_mwform_input_shortcode_tag( $output, $tag, $attr ) {
    // ログインしている場合
    if ( is_user_logged_in() ) {
        if ( $tag == 'mwform_text' && $attr['name'] == 'name' ) {
            $output = str_replace( '<input ', '<input readonly ', $output );
        }
    }
    return $output;
}
add_filter( 'do_shortcode_tag', 'teenut_autocomplete_mwform_input_shortcode_tag', 10, 3 );
