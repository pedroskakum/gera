<?php
/** @package    Gera::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * NotaMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the NotaDAO to the nota datastore.
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
class NotaMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","nota","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nota"] = new FieldMap("Nota","nota","nota",false,FM_TYPE_FLOAT,null,null,false);
			self::$FM["Avaliador"] = new FieldMap("Avaliador","nota","avaliador",false,FM_TYPE_INT,11,null,false);
			self::$FM["Artigo"] = new FieldMap("Artigo","nota","artigo",false,FM_TYPE_INT,11,null,false);
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
			self::$KM["nota_ibfk_1"] = new KeyMap("nota_ibfk_1", "Artigo", "Artigo", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["nota_ibfk_2"] = new KeyMap("nota_ibfk_2", "Avaliador", "Usuario", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return self::$KM;
	}

}

?>