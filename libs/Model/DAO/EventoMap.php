<?php
/** @package    Gera::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * EventoMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the EventoDAO to the evento datastore.
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
class EventoMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","evento","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","evento","nome",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["DataInicio"] = new FieldMap("DataInicio","evento","data_inicio",false,FM_TYPE_DATE,null,null,false);
			self::$FM["DataFim"] = new FieldMap("DataFim","evento","data_fim",false,FM_TYPE_DATE,null,null,false);
			self::$FM["MaximoArtigos"] = new FieldMap("MaximoArtigos","evento","maximo_artigos",false,FM_TYPE_INT,11,null,false);
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
			self::$KM["artigo_ibfk_1"] = new KeyMap("artigo_ibfk_1", "Id", "Artigo", "Evento", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return self::$KM;
	}

}

?>