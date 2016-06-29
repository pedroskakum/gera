<?php
/** @package    Gera::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * ArtigoMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the ArtigoDAO to the artigo datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Gera::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class ArtigoMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	/**
	 * {@inheritdoc}
	 */
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Id"] = new FieldMap("Id","artigo","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","artigo","nome",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["CaminhoArtigo"] = new FieldMap("CaminhoArtigo","artigo","caminho_artigo",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["Evento"] = new FieldMap("Evento","artigo","evento",false,FM_TYPE_INT,11,null,false);
			self::$FM["Autor"] = new FieldMap("Autor","artigo","autor",false,FM_TYPE_INT,11,null,false);
		}
		return self::$FM;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["nota_ibfk_1"] = new KeyMap("nota_ibfk_1", "Id", "Nota", "Artigo", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["artigo_ibfk_1"] = new KeyMap("artigo_ibfk_1", "Evento", "Evento", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["artigo_ibfk_2"] = new KeyMap("artigo_ibfk_2", "Autor", "Usuario", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return self::$KM;
	}

}

?>