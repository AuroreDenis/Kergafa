<?php

use Drupal\views\ViewExecutable;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\image\Entity\ImageStyle;
use Drupal\file\Entity\File;

/**
 * Implements hook_preprocess_HOOK() for block content.
 *
 */
function kergafa_theme_preprocess_block(&$variables) {
    $variables['base_path'] = base_path();
    $variables['year'] = date('Y');
}

/* fonction pour le bloc de titre*/
/*function kergafa_theme_preprocess_block__kergafa_theme_page_title(&$variables) {
    $content = $variables['content'];
    $elements = $variables['elements'];
    $node = Node::load($elements['#node']->get('nid')->value);
    $variables['titre'] = $node->getTitle();
	}*/
	
function kergafa_theme_theme_suggestions_page_alter(array &$suggestions, array $variables) {
    
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
        $route_name = \Drupal::routeMatch()->getRouteName();
        if ($route_name != 'entity.node.edit_form' && $route_name != 'entity.node.delete_form') {
            $suggestions[] = 'page__node__' . $node->bundle();
        }
    }
}

function kergafa_theme_preprocess_page_title(&$variables)
{
    if (\Drupal::routeMatch()->getParameter('node')) {
       
        $node = \Drupal::routeMatch()->getParameter('node');
        $type = $node->getType();
   
   		$variables['intro'] = false;
        if ($type == 'contenu') {
            if ($node->get('body')->value) {
                $variables['intro'] = new FormattableMarkup($node->get('body')->value, array());
            }
        }
        $variables['node_type'] = $node->getType();
        $variables['node_id'] = $node->id();
    }
}

function kergafa_theme_preprocess_views_view_unformatted__slider_accueil(&$variables)
{
    $rows = $variables['rows'];

    foreach ($rows as $key => $row) {

        $node = Node::load($row['content']['#row']->nid);
        
        $variables['rows'][$key]['node']['titre'] = $node->getTitle();
		$variables['rows'][$key]['node']['sous_titre'] = $node->get('field_sous_titre_slider')->value ? $node->get('field_sous_titre_slider')->value : false;
        $variables['rows'][$key]['node']['texte'] = $node->get('field_texte_slider')->value ? new FormattableMarkup($node->get('field_texte_slider')->value, array()) : false;
        $variables['rows'][$key]['node']['url_btn'] = $node->get('field_lien_slider')->uri ? $node->get('field_lien_slider')->first()->getUrl() : false;
        $variables['rows'][$key]['node']['texte_btn'] = $node->get('field_lien_slider')->title ? $node->get('field_lien_slider')->title : false;
        
        if ($node->get('field_slider_image')->entity) {
            $variables['rows'][$key]['node']['image_url'] = ImageStyle::load('slider_accueil')->buildUrl($node->get('field_slider_image')->entity->getFileUri());
        }
    }
}

function kergafa_theme_preprocess_views_view_unformatted__univers__block_1(&$variables)
{
    $rows = $variables['rows'];
    foreach ($rows as $key => $row) {

        $node_univers = Node::load($row['content']['#row']->nid);
		$variables['rows'][$key]['node']['titre'] = $node_univers->getTitle();
		$variables['rows'][$key]['node']['id'] = $node_univers->id();
		$liste_metiers = array();
		if ($node_univers->id() == 81 || $node_univers->id() == 64 || $node_univers->id() == 66) {
			foreach ($node_univers->get('field_metiers')->getValue() as $metier) {
				$liste_metiers[] = $metier['value'];
			}
		}
		$variables['rows'][$key]['node']['metiers'] = $liste_metiers;
    }
}

function kergafa_theme_preprocess_views_view_unformatted__univers__block_2(&$variables)
{
    $rows = $variables['rows'];

    foreach ($rows as $key => $row) {

        $node_univers = Node::load($row['content']['#row']->nid);
		$variables['rows'][$key]['node']['id'] = $node_univers->id();
		
		$variables['rows'][$key]['node']['titre'] = $node_univers->getTitle();
		$liste_metiers =  array();
		foreach ($node_univers->get('field_metiers')->getValue() as $metier) {
				$liste_metiers[] = $metier['value'];
			}
		$variables['rows'][$key]['node']['metiers'] = $liste_metiers;
		if ($node_univers->get('field_image_univers')->entity) {
            $variables['rows'][$key]['node']['image_url'] = ImageStyle::load('liste_univers')->buildUrl($node_univers->get('field_image_univers')->entity->getFileUri());
        }
	}
}


function kergafa_theme_preprocess_views_view_unformatted__realisation_block1__block_1(&$variables)
{
    $rows = $variables['rows'];

    foreach ($rows as $key => $row) {

        $node_real = Node::load($row['content']['#row']->nid);
		
		$variables['rows'][$key]['node']['titre'] = $node_real->getTitle();
		$variables['rows'][$key]['node']['espace_maison'] = $node_real->get('field_titre')->value;
		$variables['rows'][$key]['node']['intitule_real'] = $node_real->get('field_sous_titre')->value;
		$variables['rows'][$key]['node']['node_id'] = $node_real->id();
		
		$real_photo = array();
		
        if ($node_real->get('field_realisation_image_details')->entity) {
			$list_real_photos = $node_real->get('field_realisation_image_details')->getValue();
			
             foreach ($list_real_photos as $k_photo => $i_photo) {
                    $file = File::load($i_photo['target_id']);
                    if ($file) {
                        $real_photo[] = array(
                            'path' => ImageStyle::load('realisation')->buildUrl($file->getFileUri()),
                            'legende' => $i_photo['title'],
                        );	
                    }
            };
        }
	$variables['rows'][$key]['node']['image_principale'] = $real_photo[0]['path'];
	}
}

function kergafa_theme_preprocess_views_view_unformatted__realisation_block1__block_2(&$variables)
{
    $rows = $variables['rows'];

    foreach ($rows as $key => $row) {

        $node_real = Node::load($row['content']['#row']->nid);
		$variables['rows'][$key]['node']['titre'] = $node_real->getTitle();
		$variables['rows'][$key]['node']['espace_maison'] = $node_real->get('field_titre')->value;
		$variables['rows'][$key]['node']['intitule_real'] = $node_real->get('field_sous_titre')->value;
		$variables['rows'][$key]['node']['node_id'] = $node_real->id();	
		
		$real_photo = array();
		
        if ($node_real->get('field_realisation_image_details')->entity) {
			$list_real_photos = $node_real->get('field_realisation_image_details')->getValue();
			
            foreach ($list_real_photos as $k_photo => $i_photo) {
                 $file = File::load($i_photo['target_id']);
                 if ($file) {
                      $real_photo[] = array(
                            'path' => ImageStyle::load('realisation')->buildUrl($file->getFileUri()),
                            'legende' => $i_photo['title'],
                        );	
                 }
            };
        }
	$variables['rows'][$key]['node']['image_principale'] = $real_photo[0]['path'];
	}
}



function kergafa_theme_preprocess_views_view_unformatted__actualites(&$variables)
{
    $rows = $variables['rows'];

    foreach ($rows as $key => $row) {

        $node = Node::load($row['content']['#row']->nid);
        
        $variables['rows'][$key]['node']['titre'] = $node->getTitle();
        $variables['rows'][$key]['node']['texte'] = $node->get('body')->value ? new FormattableMarkup(mb_strimwidth(strip_tags($node->get('body')->value), 0, 170, '...'),  array()) : false;
        $variables['rows'][$key]['node']['node_id'] = $node->id();
        $variables['rows'][$key]['node']['date'] = $node->get('field_date_actu')->value ? $node->get('field_date_actu')->value : false;
        
        if ($node->get('field_image_actu')->entity) {
			
            $variables['rows'][$key]['node']['image_url'] = ImageStyle::load('liste_actualite')->buildUrl($node->get('field_image_actu')->entity->getFileUri());
        }
    }
}

function kergafa_theme_preprocess_views_view_unformatted__actualites__page(&$variables)
{
    $rows = $variables['rows'];

    foreach ($rows as $key => $row) {

        $node = Node::load($row['content']['#row']->nid);
    
        $variables['rows'][$key]['node']['titre'] = $node->getTitle();
        $variables['rows'][$key]['node']['texte'] = $node->get('body')->value ? new FormattableMarkup(mb_strimwidth(strip_tags($node->get('body')->value), 0, 170, '...'),  array()) : false;
        $variables['rows'][$key]['node']['node_id'] = $node->id();
        $variables['rows'][$key]['node']['date'] = $node->get('field_date_actu')->value ? $node->get('field_date_actu')->value : false;
        
        if ($node->get('field_image_actu')->entity) {
            $variables['rows'][$key]['node']['image_url'] = ImageStyle::load('liste_actualite')->buildUrl($node->get('field_image_actu')->entity->getFileUri());
        }
	
        $class = 'tous';
		if ($list_theme = $node->get('field_theme')->getValue()) {
			$variables['rows'][$key]['node']['carrelage'] = 0;
			$variables['rows'][$key]['node']['plomberie'] = 0;
        	foreach ($list_theme as $k_theme) {	
				if( $k_theme['value']=='Carrelage'){
                                    $class .= ' carrelage';
								$variables['rows'][$key]['node']['carrelage'] = 1;}
				if( $k_theme['value']=='Plomberie'){
                                    $class .= ' plomberie';
								$variables['rows'][$key]['node']['plomberie'] = 1;}
				if( $k_theme['value']=='Ker GAFA'){
                                    $class .= ' kg';
								$variables['rows'][$key]['node']['kg'] = 1;}
				if( $k_theme['value']=='Recrutement'){
                                    $class .= ' recrutement';
								$variables['rows'][$key]['node']['recrutement'] = 1;}
			}
        } 
        $variables['rows'][$key]['node']['class_categories'] = $class;
    }
}

function kergafa_theme_preprocess_node__actualite(&$variables) {

    $content = $variables['content'];
    $elements = $variables['elements'];
    $node = Node::load($elements['#node']->get('nid')->value);
    $variables['titre'] = $node->getTitle();
    $variables['date'] = $node->get('field_date_actu')->value ? $node->get('field_date_actu')->value : false;
    $variables['texte'] = $node->get('body')->value ? new FormattableMarkup($node->get('body')->value, array()) : false;
    $variables['image_url'] = $node->get('field_image_actu')->entity ? ImageStyle::load('photo_contenu')->buildUrl($node->get('field_image_actu')->entity->getFileUri()) : false;
    
    $block = \Drupal\block\Entity\Block::load('kergafa_theme_breadcrumbs');
    $variables['breadcrumbs'] = \Drupal::entityManager()
        ->getViewBuilder('block')
        ->view($block);
		
	if ($list_theme = $node->get('field_theme')->getValue()) {
			$variables['carrelage'] = 0;
			$variables['plomberie'] = 0;
			$variables['kg'] = 0;
			$variables['recrutement'] = 0;
        	foreach ($list_theme as $k_theme) {	
				if( $k_theme['value']=='Carrelage'){
								$variables['carrelage'] = 1;}
				if( $k_theme['value']=='Plomberie'){
								$variables['plomberie'] = 1;}
				if( $k_theme['value']=='Ker GAFA'){
								$variables['kg'] = 1;}
				if( $k_theme['value']=='Recrutement'){
								$variables['recrutement'] = 1;}
			}
        }   
		$actu_photos = array();
        if ($node->get('field_image_details')->entity) {
			$list_actu_photos = $node->get('field_image_details')->getValue();
			
             foreach ($list_actu_photos as $k_photo => $i_photo) {
                    $file = File::load($i_photo['target_id']);
                    if ($file) {
                        $actu_photos[] = array(
                            'path' => ImageStyle::load('photo_contenu')->buildUrl($file->getFileUri()),
                            'legende' => $i_photo['title'],
                        );	
                    }
                }
            };
	$variables['image_details'] = $actu_photos;			
}

function kergafa_theme_preprocess_node__realisation(&$variables) {

    $content = $variables['content'];
    $elements = $variables['elements'];

    $node_real = Node::load($elements['#node']->get('nid')->value);
    
    $variables['titre'] = $node_real->getTitle();
	$variables['espace_maison'] = $node_real->get('field_titre')->value;
	$variables['intitule_real'] = $node_real->get('field_sous_titre')->value;
    if($node_real->get('field_realisation_details')->value){
    	$variables['texte'] =  new FormattableMarkup($node_real->get('field_realisation_details')->value, array());
	}
    $block = \Drupal\block\Entity\Block::load('kergafa_theme_breadcrumbs');
    $variables['breadcrumbs'] = \Drupal::entityManager()
        ->getViewBuilder('block')
        ->view($block);
	$real_photo = array();
        if ($node_real->get('field_realisation_image_details')->entity) {
			$list_real_photos = $node_real->get('field_realisation_image_details')->getValue();
             foreach ($list_real_photos as $k_photo => $i_photo) {
                    $file = File::load($i_photo['target_id']);
                    if ($file) {
                        $real_photo[] = array(
                            'path' => ImageStyle::load('photo_real')->buildUrl($file->getFileUri()),
                            'legende' => $i_photo['title'],
                        );	
                    }
                }
            };
	$variables['image_details'] = $real_photo;
}

function kergafa_theme_preprocess_node__contenu(&$variables) {

    $content = $variables['content'];
    $elements = $variables['elements'];

    $node = Node::load($elements['#node']->get('nid')->value);
    
    $variables['intro'] = $node->get('body')->value ? new FormattableMarkup($node->get('body')->value, array()) : false;

    if ($list_para = $node->get('field_paragraphes')->getValue()) {
        $variables['paragraphes'] = get_paras_data($list_para);
    }
}

function get_paras_data($list_para) {
    
    foreach ($list_para as $key => $item) {
        $node_para = Node::load($item['target_id']);

        //PARAGRAPHE
        if ($node_para && $node_para->getType() == 'paragraphe') {
            $para_photos = array();
            if ($list_para_photos = $node_para->get('field_para_photos')->getValue()) {
                foreach ($list_para_photos as $k_photo => $i_photo) {
                    $file = File::load($i_photo['target_id']);
                    if ($file) {
                        $para_photos[] = array(
                            'path' => ImageStyle::load('photo_contenu')->buildUrl($file->getFileUri()),
                            'legende' => $i_photo['title'],
                        );
                    }
                }
            }

            $para_pos = $node_para->get('field_para_pos_photos')->value;
            if (!$para_pos)
                $para_pos = 1;

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'body' => new FormattableMarkup($node_para->get('body')->value, array()),
                'photos' => $para_photos,
                'nb_photos' => count($para_photos) > 4 ? 'more' : count($para_photos),
                'pos_photos' => $para_pos,
            );

            //DOCUMENTS
        } elseif ($node_para && $node_para->getType() == 'documents') {

            $documents = false;
            if ($liste_documents = $node_para->get('field_fichiers')->getValue()) {
                $documents =  array();
                foreach ($liste_documents as $key2 => $item) {

                    $file = File::load($item['target_id']);
                    if ($file) {
                        if (strpos($file->getFilename(), '.pdf') !== false) {
                            $type = 'pdf';
                        } elseif (strpos($file->getFilename(), '.xls') !== false || strpos($file->getFilename(), '.xlsx') !== false) {
                            $type = 'xls';
                        } elseif (strpos($file->getFilename(), '.ppt') !== false || strpos($file->getFilename(), '.pptx') !== false) {
                            $type = 'ppt';
                        } elseif (strpos($file->getFilename(), '.doc') !== false || strpos($file->getFilename(), 'docx') !== false) {
                            $type = 'doc';
                        } else {
                            $type = 'other';
                        }
                    }
                    $documents[] = [
                        'titre' => $item['description'] ? $item['description'] : false,
                        'url_fichier' => file_create_url($file->getFileUri()),
                        'type' => $type,
                        'nom_fichier' => $file->getFilename()
                    ];
                }
            }

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'documents' => $documents
            );
            //ACCORDEON	
        } elseif ($node_para && $node_para->getType() == 'accordeon') {
            if ($node_para->get('field_elements_accordeon')->entity) {
                $elements = [];
                foreach ($node_para->get('field_elements_accordeon')->getValue() as $key => $item) {
                    $node_elem_acc = Node::load($item['target_id']);

                    $elements[] = [
                        'titre' => $node_elem_acc->getTitle(),
                        'texte' => new FormattableMarkup($node_elem_acc->get('field_texte_element_accordeon')->value, array()),
                    ];
                }
            } else {
                $elements = [];
            }

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'elements' => $elements,
            );

            //BLOC DE CONTENU
        } elseif ($node_para && $node_para->getType() == 'bloc_contenu') {

            $block_content = '';
            if ($node_para->get('field_bloc_contenu_ref')->entity) {
                $block = \Drupal\block\Entity\Block::load($node_para->get('field_bloc_contenu_ref')->entity->id());
                $block_content = \Drupal::entityTypeManager()
                        ->getViewBuilder('block')
                        ->view($block);
            }

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'bloc' => $block_content,
            );

            //GALERIE PHOTOS
        } elseif ($node_para && $node_para->getType() == 'photo_contenu') {

            $para_photos = array();
            if ($list_para_photos = $node_para->get('field_photo_contenu_photos')->getValue()) {
                foreach ($list_para_photos as $k_photo => $i_photo) {
                    $file = File::load($i_photo['target_id']);
                    if ($file) {
                        $para_photos[] = array(
                            'path' => ImageStyle::load('photo_contenu')->buildUrl($file->getFileUri()),
                            'legende' => $i_photo['title'],
                        );
                    }
                }
            }

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'photos' => $para_photos,
                'nb_photos' => count($para_photos) > 4 ? 'more' : count($para_photos),
            );

            //GRAPHIQUE
        } elseif ($node_para && $node_para->getType() == 'graphique') {
            $variables['#attached']['library'][] = 'aserti_theme/google-charts';

            $graph_type = $node_para->get('field_graph_type')->value;

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
            );

            $data_color = [];
            $data_table = [['']]; // Titre axe des abscisses
            $data_table_pie = [['', '']]; // Titre axe des abscisses

            $abscisses = explode(';', $node_para->get('field_graph_abscisse')->value);
            foreach ($abscisses as $k_a => $i_a) {
                $data_table[$k_a + 1] = [$i_a];
            }


            foreach ($node_para->get('field_graph_donnees')->getValue() as $k_d => $i_d) {
                $node_data = Node::load(intval($i_d['target_id']));
                if ($node_data && $node_data->getType() == 'donnees_graphique') {
                    $data_color[] = $node_data->get('field_dgraph_couleur')->color;

                    $data_table[0][] = $node_data->getTitle();

                    $data_table_pie[] = [
                        $node_data->getTitle(),
                        floatval($node_data->get('field_dgraph_donnees')->value),
                    ];

                    $courbe_data = explode(';', $node_data->get('field_dgraph_donnees')->value);
                    foreach ($courbe_data as $k_d => $i_d) {
                        $data_table[$k_d + 1][] = floatval($i_d);
                    }
                }
            }

            $variables['#attached']['drupalSettings']['page_contenu']['para_graph'][] = [
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'graph_type' => $graph_type,
                'data_table' => ($graph_type == 'pie') ? $data_table_pie : $data_table,
                'data_color' => $data_color,
            ];

            //VIDEO
        } elseif ($node_para && $node_para->getType() == 'video_contenu') {

            $field_video_contenu_video = $node_para->get('field_video_contenu_video')->view(['label' => 'hidden', 'settings' => ['autoplay' => false, 'responsive' => true]]);
            $para_video = \Drupal::service('renderer')->render($field_video_contenu_video);

            $variables['paragraphes'][] = array(
                'id' => $node_para->id(),
                'type' => $node_para->getType(),
                'title' => $node_para->getTitle(),
                'title_display' => !$node_para->get('field_contenu_masquer_titre')->value,
                'video' => $para_video,
            );
        }
    }

    return $variables['paragraphes'];
}
