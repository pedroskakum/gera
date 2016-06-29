<?php
/** @package    GERA::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Evento.php");

/**
 * EventoController is the controller class for the Evento object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package GERA::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class EventoController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Evento objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Evento records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new EventoCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Nome,DataInicio,DataFim,MaximoArtigos'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$eventos = $this->Phreezer->Query('Evento',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $eventos->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $eventos->TotalResults;
				$output->totalPages = $eventos->TotalPages;
				$output->pageSize = $eventos->PageSize;
				$output->currentPage = $eventos->CurrentPage;
			}
			else
			{
				// return all results
				$eventos = $this->Phreezer->Query('Evento',$criteria);
				$output->rows = $eventos->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Evento record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$evento = $this->Phreezer->Get('Evento',$pk);
			$this->RenderJSON($evento, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Evento record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$evento = new Evento($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $evento->Id = $this->SafeGetVal($json, 'id');

			$evento->Nome = $this->SafeGetVal($json, 'nome');
			$evento->DataInicio = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dataInicio')));
			$evento->DataFim = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dataFim')));
			$evento->MaximoArtigos = $this->SafeGetVal($json, 'maximoArtigos');

			$evento->Validate();
			$errors = $evento->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$evento->Save();
				$this->RenderJSON($evento, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Evento record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$evento = $this->Phreezer->Get('Evento',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $evento->Id = $this->SafeGetVal($json, 'id', $evento->Id);

			$evento->Nome = $this->SafeGetVal($json, 'nome', $evento->Nome);
			$evento->DataInicio = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dataInicio', $evento->DataInicio)));
			$evento->DataFim = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dataFim', $evento->DataFim)));
			$evento->MaximoArtigos = $this->SafeGetVal($json, 'maximoArtigos', $evento->MaximoArtigos);

			$evento->Validate();
			$errors = $evento->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$evento->Save();
				$this->RenderJSON($evento, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Evento record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$evento = $this->Phreezer->Get('Evento',$pk);

			$evento->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
