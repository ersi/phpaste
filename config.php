<?php
/*
* $ID config.php, v1 EcKstasy - 16/03/2010/00:00 GMT+1 (dd/mm/yy/time) 
* 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 3
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*/
 
// MySQL database
$CONF['dbhost']='localhost';
$CONF['dbname']='mysqldatabase';
$CONF['dbuser']='mysqluser';
$CONF['dbpass']='databasepassword';

// This should be the URL to your pastebin. eg: http://paste.info.tm/ or http://paste.info.tm/subdir/
$CONF['url']='http://paste.info.tm/';// Make sure you end it with a forward slash! (/)

// What is the name of the template you want to use (the folder as displayed in /templates/)
$CONF['template']='default';

// Site title (Appears in the <title></title> tags)
$CONF['title']='PASTE - The name says it all.';

// Do you want to enable reCAPTCHA support on your pastebin? false = no, true = yes
$CONF['useRecaptcha'] = false;
// Get your keys at http://recaptcha.net/
$CONF['pubkey']='yourpublickey';
$CONF['privkey']='yourprivatekey';

/* 
* Format of the URLs to the pastebin entries. %d = Entry ID.
* If you're using Apache's mod_rewrite you'd use something like this: $CONF['url_format']="%d";
* If you're not using mod_rewrite, you'll need to use something like:
* $CONF['url_format']="?show=%d";
*/
$CONF['url_format']='%d';

// Default expiry time - d (day), m (month), and f (forever).
$CONF['default_expiry']='f';

// The maximum number of posts you want to keep. Keep this as-is if you want no limits.
$CONF['max_posts']=0;

// What's the character you want to use for highlighting certain lines in pastes?
$CONF['highlight_prefix']='@@';

// Default syntax highlight for pastes.
$CONF['default_highlighter']='text';

// Available formats (All GeSHi formats are here)
$CONF['geshiformats']=array(
	'abap'=>'ABAP',
	'actionscript'=>'ActionScript',
	'actionscript3'=>'ActionScript 3',
	'ada'=>'Ada',
	'apache'=>'Apache',
	'applescript'=>'AppleScript',
	'apt_sources'=>'Apt sources.list',
	'asm'=>'ASM',
	'asp'=>'ASP',
	'autoit'=>'AutoIt',
	'avisynth'=>'AviSynth',
	'bash'=>'BASH',
	'basic4gl'=>'Basic4GL',
	'bf'=>'Brainfuck',
	'bibtex'=>'BibTeX',
	'blitzbasic'=>'BlitzBasic',
	'bnf'=>'BNF',
	'boo'=>'Boo',
	'c'=>'C',
	'c_mac'=>'C for Macs',
	'caddcl'=>'CADDCL',
	'cadlisp'=>'CADLisp',
	'cfdg'=>'CFDG',
	'cfm'=>'ColdFusion',
	'cil'=>'CIL',
	'cmake'=>'CMake',
	'cobol'=>'COBOL',
	'cpp-qt'=>'C++ (with QT extensions)',
	'cpp'=>'C++',
	'csharp'=>'C#',
	'css'=>'CSS',
	'd'=>'D',
	'dcs'=>'DCS',
	'delphi'=>'Delphi',
	'diff'=>'Diff-output',
	'div'=>'DIV',
	'dos'=>'DOS',
	'dot'=>'dot',
	'eiffel'=>'Eiffel',
	'email'=>'E-mail (mbox\eml\RFC format)',
	'erlang'=>'Erlang',
	'fo'=>'FO',
	'fortran'=>'Fortran',
	'freebasic'=>'FreeBasic',
	'genero'=>'Genero',
	'gettext'=>'GNU Gettext .po/.pot',
	'glsl'=>'glSlang',
	'gml'=>'GML',
	'gnuplot'=>'GNUPlot',
	'groovy'=>'Groovy',
	'haskell'=>'Haskell',
	'hq9plus'=>'HQ9+',
	'html4strict'=>'HTML 4.01 strict',
	'idl'=>'Unoidl',
	'ini'=>'INI',
	'inno'=>'Inno Script',
	'intercal'=>'INTERCAL',
	'io'=>'IO',
	'java'=>'Java',
	'java5'=>'Java 5',
	'javascript'=>'JavaScript',
	'kixtart'=>'KiXtart',
	'klonec'=>'KLone with C',
	'klonecpp'=>'KLone with C++',
	'latex'=>'LaTeX',
	'lisp'=>'Generic Lisp',
	'locobasic'=>'Locomotive Basic',
	'lolcode'=>'LOLcode',
	'lotusformulas'=>'@Formula/@Command',
	'lotusscript'=>'LotusScript',
	'lscript'=>'Lightwave Script',
	'lsl2'=>'Linden Script',
	'lua'=>'LUA',
	'm68k'=>'Motorola 68000 Assembler',
	'make'=>'GNU make',
	'matlab'=>'Matlab',
	'mirc'=>'mIRC',
	'modula3'=>'Modula-3',
	'mpasm'=>'Microchip Assembler',
	'mxml'=>'MXML',
	'mysql'=>'MySQL',
	'nsis'=>'NSIS',
	'oberon2'=>'Oberon-2',
	'objc'=>'Objective-C',
	'ocaml-brief'=>'Objective Caml',
	'oobas'=>'OOo Basic',
	'oracle11'=>'Oracle 11i',
	'oracle8'=>'Oracle 8',
	'pascal'=>'Pascal',
	'per'=>'Per (forms)',
	'perl'=>'Perl',
	'php-brief'=>'PHP (Brief version)',
	'php'=>'PHP',
	'pic16'=>'PIC16 Assembler',
	'pixelbender'=>'Pixel Bender',
	'text'=>'Plain text',
	'plsql'=>'Oracle 9.2 PL/SQL',
	'povray'=>'Povray',
	'powershell'=>'PowerShell',
	'progress'=>'Progress',
	'prolog'=>'Prolog',
	'properties'=>'Property',
	'providex'=>'ProvideX',
	'python'=>'Python',
	'qbasic'=>'QuickBASIC',
	'rails'=>'Ruby on Rails',
	'rebol'=>'Rebol',
	'reg'=>'Microsoft REGEDIT',
	'robots'=>'Robots.txt',
	'ruby'=>'Ruby',
	'sas'=>'SAS',
	'scala'=>'Scala',
	'scheme'=>'Scheme',
	'scilab'=>'SciLab',
	'sdlbasic'=>'sdlBasic',
	'smalltalk'=>'Smalltalk',
	'smarty'=>'Smarty',
	'sql'=>'SQL',
	'tcl'=>'TCL',
	'teraterm'=>'Tera Term Macro',
	'thinbasic'=>'thinBasic',
	'tsql'=>'T-SQL',
	'typoscript'=>'TypoScript',
	'vb'=>'Visual Basic',
	'vbnet'=>'Visual Basic .NET',
	'verilog'=>'Verilog',
	'vhdl'=>'VHDL',
	'vim'=>'Vim',
	'visualfoxpro'=>'Visual FoxPro',
	'visualprolog'=>'Visual Prolog',
	'whitespace'=>'Whitespace',
	'whois'=>'WHOIS (RPSL format)',
	'winbatch'=>'WinBatch',
	'xml'=>'XML',
	'xorg_conf'=>'xorg.conf',
	'xpp'=>'Axapta/Dynamics Ax X++',
	'z80'=>'ZiLOG Z80 Assembler',
);

// The formats that are listed first.
$CONF['popular_syntax']=array(
	'text','bash','html4strict', 'css', 'javascript', 'php',
	'perl','python','sql','ruby', 'rails', 'tcl', 'xml',
	'whois','xorg_conf','java','apt_sources','mirc','c','cpp',
);
?>