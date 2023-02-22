<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * WordPress Widgets Helper Class
 *
 * https://github.com/sksmatt/WordPress-Widgets-Helper-Class
 *
 * By @sksmatt | www.mattvarone.com
 *
 * @package      WordPress
 * @subpackage   WPH Widget Class
 * @author       Matt Varone & riesurya & Mte90
 * @license      GPLv2
 * @version      1.6-enhancements
 */
if ( !class_exists( 'WPH_Widget' ) && class_exists( 'WP_Widget' ) ) {

	class WPH_Widget extends WP_Widget {

		/**
		 * Create Widget 
		 * 
		 * Creates a new widget and sets it's labels, description, fields and options 
		 * 
		 * @access   public
		 * @param    array
		 * @return   void
		 * @since    1.0
		 */
		function create_widget( $args ) {
			// settings some defaults
			$defaults = array(
				'label' => '',
				'description' => '',
				'slug' => '',
				'classname' => '',
				'width' => array(),
				'height' => array(),
				'fields' => array(),
				'options' => array(),
			);

			// parse and merge args with defaults
			$args = wp_parse_args( $args, $defaults );

			// extract each arg to its own variable
			extract( $args, EXTR_SKIP );

			// set the widget vars
			$this->slug = $slug;
			$this->classname = $slug;
			$this->fields = $fields;
			$this->width = $width;
			$this->height = $height;
			if( !empty( $classname ) ) {
				$this->classname = $classname;
			}

			// check options
			$this->options = array( 'classname' => $this->classname, 'description' => $description, 'cache' => false );
			if ( !empty( $options ) ) {
				$this->options = array_merge( $this->options, $options );
			}

			// call WP_Widget to create the widget
			parent::__construct( $this->slug, $label, $this->options, $this->width, $this->height );
		}

		/**
		 * Form
		 * 
		 * Creates the settings form. 
		 * 
		 * @access   private
		 * @param    array
		 * @return   void
		 * @since    1.0     
		 */
		function form( $instance ) {
			$this->instance = $instance;
			$form = '';
			if ( $this->options[ 'cache' ] === true ) {
				$widget_id = $this->get_field_id( 'title' );
				$key = $this->options[ 'classname' ] . '_' . $widget_id;
				$form = get_transient( $key );
			}
			if ( empty( $form ) ) {
				$form = $this->create_fields();
				if ( $this->options[ 'cache' ] === true ) {
					set_transient( $key, $form, DAY_IN_SECONDS );
				}
			}

			echo $form;
			do_action( 'wph_print_form' );
		}

		/**
		 * Update Fields
		 *  
		 * @access   private
		 * @param    array
		 * @param    array
		 * @return   array
		 * @since    1.0
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$this->before_update_fields();

			foreach ( $this->fields as $key ) {
				
				$slug = (isset($key['id'])) ? $key['id'] : $key['param_name'];

				if ( isset( $key[ 'validate' ] ) ) {
					if ( false === $this->validate( $key[ 'validate' ], $new_instance[ $slug ] ) ) {
						return $instance;
					}
				}

				if ( isset( $key[ 'filter' ] ) ) {
					$instance[ $slug ] = $this->filter( $key[ 'filter' ], $new_instance[ $slug ] );
				} else {
					@$instance[ $slug ] = strip_tags( $new_instance[ $slug ] );

				}
			}

			return $this->after_validate_fields( $instance );
		}

		/**
		 * Before Validate Fields
		 *
		 * Allows to hook code on the update.
		 *  
		 * @access   public
		 * @param    string
		 * @return   string
		 * @since    1.6
		 */
		function before_update_fields() {
			return;
		}

		/**
		 * After Validate Fields
		 * 
		 * Allows to modify the output after validating the fields.
		 *
		 * @access   public
		 * @param    string
		 * @return   string
		 * @since    1.6
		 */
		function after_validate_fields( $instance = "" ) {
			return $instance;
		}

		/**
		 * Validate 
		 *  
		 * @access   private
		 * @param    string
		 * @param    string
		 * @return   boolean
		 * @since    1.0
		 */
		function validate( $rules, $value ) {
			$rules = explode( '|', $rules );

			if ( empty( $rules ) || count( $rules ) < 1 ) {
				return true;
			}

			foreach ( $rules as $rule ) {
				if ( false === $this->do_validation( $rule, $value ) ) {
					return false;
				}
			}

			return true;
		}

		/**
		 * Filter 
		 *  
		 * @access   private
		 * @param    string
		 * @param    string
		 * @return   void
		 * @since    1.0
		 */
		function filter( $filters, $value ) {
			$filters = explode( '|', $filters );

			if ( empty( $filters ) || count( $filters ) < 1 ) {
				return $value;
			}

			foreach ( $filters as $filter ) {
				$value = $this->do_filter( $filter, $value );
			}

			return $value;
		}

		/**
		 * Do Validation Rule
		 *  
		 * @access   private
		 * @param    string
		 * @param    string
		 * @return   boolean
		 * @since    1.0
		 */
		function do_validation( $rule, $value = "" ) {
			switch ( $rule ) {

				case 'alpha':
					return ctype_alpha( $value );
					break;

				case 'alpha_numeric':
					return ctype_alnum( $value );
					break;

				case 'alpha_dash':
					return preg_match( '/^[a-z0-9-_]+$/', $value );
					break;

				case 'numeric':
					return ctype_digit( $value );
					break;

				case 'integer':
					return ( bool ) preg_match( '/^[\-+]?[0-9]+$/', $value );
					break;

				case 'boolean':
					return is_bool( $value );
					break;

				case 'email':
					return is_email( $value );
					break;

				case 'decimal':
					return ( bool ) preg_match( '/^[\-+]?[0-9]+\.[0-9]+$/', $value );
					break;

				case 'natural':
					return ( bool ) preg_match( '/^[0-9]+$/', $value );
					return;

				case 'natural_not_zero':
					if ( !preg_match( '/^[0-9]+$/', $value ) )
						return false;
					if ( $value == 0 )
						return false;
					return true;
					return;

				default:
					if ( method_exists( $this, $rule ) ) {
						return $this->$rule( $value );
					} else {
						return false;
					}
					break;
			}
		}

		/**
		 * Do Filter
		 *  
		 * @access   private
		 * @param    string
		 * @param    string
		 * @return   boolean
		 * @since    1.0
		 */
		function do_filter( $filter, $value = "" ) {
			switch ( $filter ) {
				case 'strip_tags':
					return strip_tags( $value );
					break;

				case 'wp_strip_all_tags':
					return wp_strip_all_tags( $value );
					break;

				case 'esc_attr':
					return esc_attr( $value );
					break;

				case 'esc_url':
					return esc_url( $value );
					break;

				case 'esc_textarea':
					return esc_textarea( $value );
					break;

				default:
					if ( method_exists( $this, $filter ) ) {
						return $this->$filter( $value );
					} else {
						return $value;
					}
					break;
			}
		}

		/**
		 * Create Fields 
		 * 
		 * Creates each field defined. 
		 * 
		 * @access   private
		 * @param    string
		 * @return   string
		 * @since    1.0
		 */
		function create_fields( $out = "" ) {
			
			$out = $this->before_create_fields( $out );

			if ( !empty( $this->fields ) ) {
				foreach ( $this->fields as $key ) {
					$out .= $this->create_field( $key );
				}
			}

			$out = $this->after_create_fields( $out );

			return $out;
		}

		/**
		 * Before Create Fields
		 *
		 * Allows to modify code before creating the fields.
		 *  
		 * @access   public
		 * @param    string
		 * @return   string
		 * @since    1.0
		 */
		function before_create_fields( $out = "" ) {
			return $out;
		}

		/**
		 * After Create Fields
		 * 
		 * Allows to modify code after creating the fields.
		 *
		 * @access   public
		 * @param    string
		 * @return   string
		 * @since    1.0
		 */
		function after_create_fields( $out = "" ) {
			return $out;
		}

		/**
		 * Create Fields
		 *  
		 * @access   private
		 * @param    string
		 * @param    string
		 * @return   string
		 * @since    1.0
		 */
		function create_field( $key, $out = "" ) {
			
			$p_data = array();
	
			/* Set Defaults */
			$key['std'] = isset( $key['std'] ) ? $key['std'] : "";
			
			if ( isset( $key['default'] ) ) {
                $key['std'] = $key['default'];
            }

			$slug = ( isset( $key['id'] ) ) ? $key['id'] : ( ( !empty(  $key['param_name'] ) ? $key['param_name'] : '' ) );
			$heading = isset( $key['heading'] ) ? $key['heading'] : '';
            $key['name'] = ( isset( $key['name'] ) ) ? $key['name'] : $heading;
			
			if ( !empty(  $key['param_name'] ) && $key['param_name'] == 'category' ) {
				
				$categories = get_categories( array(
					'type' => 'post',
					'child_of' => 0,
					'parent' => '',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => false,
					'hierarchical' => 1,
					'exclude' => '',
					'include' => '',
					'number' => '',
					'taxonomy' => 'product_cat',
					'pad_counts' => false,

				) );

				$product_categories_dropdown = array(
					esc_html__( 'Select Category', 'powernodewt' ) => '',
				);
				
				getCategoryChildsFull( 0, $categories, 0, $product_categories_dropdown );
				
				$key['value'] = $product_categories_dropdown;

			}
			
			/* Set description  */
			if ( !empty( $key['widget_description'] ) ) {
                $key['description'] = $key['widget_description'];
            }
			if ( isset( $key['description'] ) ) {
                $key['desc'] = $key['description'];
            }
			
			/* Set fields value  */
			if ( isset( $key['value'] ) ) {
                $key['fields'] = $key['value'];
            }

			if ( isset( $this->instance[ $slug ] ) ) {
				$key[ 'value' ] = empty( $this->instance[ $slug ] ) ? '' : strip_tags( $this->instance[ $slug ] );
			} else {
				unset( $key[ 'value' ] );
			}

			/* Set field id and name  */
			$key[ '_id' ] = $this->get_field_id( $slug );
			$key[ '_name' ] = $this->get_field_name( $slug );

			/* Set field type */
			if ( !isset( $key[ 'type' ] ) ) {
				$key[ 'type' ] = 'text';
			}
			$key[ 'type' ] = $this->powernodewt_change_field_type( $key[ 'type' ] );
			
			/* Set field class */
			$key['class'] = ( !empty( $key['class'] ) ) ? $key['class'].' widefat' : 'widefat';
			$key['class'] .= $this->powernodewt_field_class ( $key[ 'type' ] );
			
			/* Prefix method */
			$field_method = 'create_field_' . str_replace( '-', '_', $key[ 'type' ] );
		
			/* Set data */
			if ( !empty( $slug ) ) {
				$p_data['data-name'] = $slug;
			}
			if ( !empty( $key['dependency'] ) ) {
				if ( is_array ( $key['dependency']  ) ) {
					foreach( $key['dependency'] as $dk => $dv ) {
						if ( is_array( $dv ) && !empty( $dv ) ) {
							$dv = implode( ',', $dv );
						}
						$p_data['data-'.$dk] = $dv;
					}
				}
			}
			
			/* Check for <p> Class */
			$p = ( isset( $key[ 'class-p' ] ) ) ? '<p class="' . $key[ 'class-p' ] . '" ' . powernodewt_stringify_atts($p_data) . ' >' : '<p ' . powernodewt_stringify_atts($p_data) . '>';

			/* Run method */
			if ( method_exists( $this, $field_method ) ) {
				return $p . $this->$field_method( $key ) . '</p>';
			}
		}
		
		function powernodewt_change_field_type ( $type ) {
			
			switch ( $type ) {
                case 'textfield':
                case 'vc_link':
                case 'href':
                case 'autocomplete':
                    $type = 'text';
					break;
                case 'attach_images':
                    $type = 'attach_image';
					break;
                case 'textarea_html':
                    $type = 'textarea';
                break;
				case 'powernode_number':
                    $type = 'number';
					break;
            }
            return $type;
		}
		
		function powernodewt_field_class ( $type ) {

			return ' powernode-widget-action powernode-widget-'.$type;
		}
        
        /** 
        * dropdown field
        *  
        * @access   private
        * @param    array
        * @param    string
        * @return   string
        * @since    1.5
        */
        
        function create_field_dropdown( $key, $out = "" )
        {
			$out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';

            $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];

            $out .= '<select id="' . esc_attr( $key['_id'] ) . '" name="' . esc_attr( $key['_name'] ) . '" data-value="' . esc_attr( $selected ) . '" ';

            if ( isset( $key['class'] ) )
                $out .= 'class="' . esc_attr( $key['class'] ) . '" ';

            $out .= '> ';

                foreach ( $key['fields'] as $field => $option ) 
                {
					
					if ( is_array( $option ) ) {
						if ( isset( $option['label'] ) && isset( $option['value'] ) ) {
							$field = $option['label'];
							$option = $option['value'];
						}
					}

                    $out .= '<option value="' . esc_attr( $option ) . '" ';

                    if ( esc_attr( $selected ) == $option )
                        $out .= ' selected="selected" ';

                    $out .= '> '.esc_html( $field ).'</option>';

                }

            $out .= ' </select> ';
            
            if ( isset( $key['desc'] ) )
                $out .= '<br/><small class="description">'.esc_html( $key['desc'] ).'</small>';

            return $out;            
        }
		
		/** 
        * attach image field
        *  
        * @access   private
        * @param    array
        * @param    string
        * @return   string
        * @since    1.5
        */
        
        function create_field_attach_image( $key, $out = "" )
        {

            $value = isset( $key['value'] ) ? $key['value'] : $key['std'];

            $url = $style = '';

            if(isset($value)) {
                $url = wp_get_attachment_url($value);
            }

            if($url == '') {
                $style = 'display:none;';
            }

            $out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';

            $out .= '<div class="media-widget-control"><div class="media-widget-preview"><img src="'.$url.'" class="powernode-image-src attachment-thumb" style="'.$style.'" /></div></div>';

            $out .= '<input type="hidden" ';

            if ( isset( $key['class'] ) )
                $out .= 'class="powernode-image-upload ' . esc_attr( $key['class'] ) . '" ';


            $out .= 'id="' . esc_attr( $key['_id'] ) . '" name="' . esc_attr( $key['_name'] ) . '" value="' . esc_attr( $value ) . '" ';

            if ( isset( $key['size'] ) )
                $out .= 'size="' . esc_attr( $key['size'] ) . '" ';             

            $out .= ' />';
			
			//$out .= '<br/>';

            $out .= '<button class="button powernode-image-upload-btn">' .__('Upload image', 'powernodewt') . '</button>';
            
            if ( isset( $key['desc'] ) )
                $out .= '<br/><small class="description">'.esc_html( $key['desc'] ).'</small>';

            return $out;
        }
		
		/**
		 * Field Colorpicker
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_colorpicker( $key, $out = "" ) {
			
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '<br/>';

			$out .= '<input type="text" ';
			
			$key[ 'class' ] = ( !empty( $key[ 'class' ] ) ) ? 'powernode-color-picker ' . $key[ 'class' ] : 'powernode-color-picker';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class=" ' . esc_attr( $key[ 'class' ] ) . '" ';
			}

			$value = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];

			$out .= 'id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" value="' . esc_attr__( $value ) . '" ';

			if ( isset( $key[ 'size' ] ) ) {
				$out .= 'size="' . esc_attr( $key[ 'size' ] ) . '" ';
			}

			$out .= ' />';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}
			
			$out .= '<script>jQuery(document).ready( function() {
				jQuery(".powernode-color-picker").wpColorPicker();
			} );</script>';

			return $out;
		}

		/**
		 * Field Text
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_text( $key, $out = "" ) {
			
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '<br/>';

			$out .= '<input type="text" ';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}

			$value = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];

			$out .= 'id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" value="' . esc_attr__( $value ) . '" ';

			if ( isset( $key[ 'size' ] ) ) {
				$out .= 'size="' . esc_attr( $key[ 'size' ] ) . '" ';
			}

			$out .= ' />';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}

			return $out;
		}

		/**
		 * Field Textarea
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_textarea( $key, $out = "" ) {
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '<br/>';

			$out .= '<textarea ';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}

			if ( isset( $key[ 'rows' ] ) ) {
				$out .= 'rows="' . esc_attr( $key[ 'rows' ] ) . '" ';
			}

			if ( isset( $key[ 'cols' ] ) ) {
				$out .= 'cols="' . esc_attr( $key[ 'cols' ] ) . '" ';
			}

			$value = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];

			$out .= 'id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '">' . esc_html( $value );

			$out .= '</textarea>';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}

			return $out;
		}

		/**
		 * Field Checkbox
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_checkbox( $key, $out = "" ) {
	
			$out .= ' <input type="checkbox" ';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}
			
			/*if ( $key['param_name'] == 'slider_nav' ) {
				print_r(array_values($key['fields']));exit;
				print_r($key);exit;
			}*/
			$value = 1;
			if ( isset( $key['fields'] ) ) { 
				$checkbox_value = array_values($key['fields']);
				if ( isset( $checkbox_value[0] ) ) {
					$value = $checkbox_value[0];
				}
			}

			$out .= 'id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" value="'.$value.'" ';

			if ( ( isset( $key[ 'value' ] ) && $key[ 'value' ] == 1 ) OR ( !isset( $key[ 'value' ] ) && $key[ 'std' ] == 1 ) ) {
				$out .= ' checked="checked" ';
			}

			$out .= ' /> ';
			
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] );

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}

			return $out;
		}

		/**
		 * Field Select
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_select( $key, $out = "" ) {
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '<br/>';

			$out .= '<select id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" ';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}

			$out .= '> ';

			$selected = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];

			foreach ( $key[ 'fields' ] as $field => $option ) {
				$out .= '<option value="' . esc_attr__( $option[ 'value' ] ) . '" ';

				if ( esc_attr( $selected ) == $option[ 'value' ] ) {
					$out .= ' selected="selected" ';
				}

				$out .= '> ' . esc_html( $option[ 'name' ] ) . '</option>';
			}

			$out .= ' </select> ';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}

			return $out;
		}

		/**
		 * Field Select with Options Group
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_select_group( $key, $out = "" ) {
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '<br/>';

			$out .= '<select id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" ';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}

			$out .= '> ';

			$selected = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];

			foreach ( $key[ 'fields' ] as $group => $fields ) {

				$out .= '<optgroup label="' . $group . '">';

				foreach ( $fields as $field => $option ) {
					$out .= '<option value="' . esc_attr( $option[ 'value' ] ) . '" ';

					if ( esc_attr( $selected ) == $option[ 'value' ] ) {
						$out .= ' selected="selected" ';
					}

					$out .= '> ' . esc_html( $option[ 'name' ] ) . '</option>';
				}

				$out .= '</optgroup>';
			}

			$out .= '</select>';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}

			return $out;
		}

		/**
		 * Field Number
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_number( $key, $out = "" ) {
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '<br/>';

			$out .= '<input type="number" ';

			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}

			$value = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];

			$out .= 'id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" value="' . esc_attr__( $value ) . '" ';

			if ( isset( $key[ 'size' ] ) ) {
				$out .= 'size="' . esc_attr( $key[ 'size' ] ) . '" ';
			}

			$out .= ' />';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<br/><small class="description">' . esc_html( $key[ 'desc' ] ) . '</small>';
			}

			return $out;
		}

		/**
		 * Field Label
		 *  
		 * @access   private
		 * @param    string
		 * @param    string
		 * @return   string
		 * @since    1.5
		 */
		function create_field_label( $name = "", $id = "" ) {
			return '<label for="' . esc_attr( $id ) . '">' . esc_html( $name ) . '</label>';
		}

		/**
		 * Field Taxonomy
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.6-enhancements
		 */
		function create_field_taxonomy( $key, $out = "" ) {
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] );
			// Build taxonomy selection boxes       
			$taxes = get_taxonomies( '', 'names' );
			$out .= '<div class="inright">';
			$out .= '<select id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" ';
			$out .= '> ';
			$selected = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];
			foreach ( $taxes as $tax ) {
				if ( ($tax == 'link_category') or ( $tax == 'nav_menu') or ( ($tax == 'post_format') and ! isset( $options[ 'post_format' ] ) ) ) {
					continue;
				}
				$taxonomy = get_taxonomy( $tax );
				$posttypes_obj = $taxonomy->object_type;
				foreach ( $posttypes_obj as $posttype_obj => $posttype ) {
					$out .= '<option value="' . esc_attr__( $taxonomy->name ) . '" ';
					if ( esc_attr( $selected ) == $taxonomy->name ) {
						$out .= ' selected="selected" ';
					}
					$out .= '> ' . esc_attr( $taxonomy->label ) . '</option>';
				}
			}
			$out .= ' </select> ';
			$out .= '</div>';
			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<p class="description"><small>' . esc_html( $key[ 'desc' ] ) . '</small></p>';
			}
			return $out;
		}

		/**
		 * Field Taxonomy Term
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.6-enhancements
		 */
		function create_field_taxonomyterm( $key, $out = "" ) {
			$out .= $this->create_field_label( $key[ 'name' ], $key[ '_id' ] );
			// Build taxonomy selection boxes       
			$taxes = get_taxonomies( '', 'names' );
			foreach ( $taxes as $tax ):
				if ( ($tax != $key[ 'taxonomy' ] ) ) {
					continue;
				}
				$taxonomy = get_taxonomy( $tax );
				$terms = get_terms( $taxonomy->name, array( 'orderby' => 'name' ) );
				$out .= '<div class="inright">';
				$out .= '<select id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" ';
				$out .= '> ';
				$selected = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];
				$out .= '<option value="any"';
				if ( esc_attr( $selected ) == 'any' ) {
					$out .= ' selected="selected" ';
				}
				$out .= '>Any Categories</option>';
				foreach ( $terms as $term ) {
					//make array as pattern ( $term->taxonomy , $term->name);
					$out .= '<option value="' . esc_attr__( $term->slug ) . '" ';
					if ( esc_attr( $selected ) == $term->slug ) {
						$out .= ' selected="selected" ';
					}
					$out .= '> ' . esc_html( $term->name ) . ' </option>';
				}
				$out .= ' </select> ';
				$out .= '</div>';
			endforeach;
			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<p class="description"><small>' . esc_html( $key[ 'desc' ] ) . '</small></p>';
			}
			return $out;
		}

		/**
		 * Pages Select
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.6-enhancements
		 */
		function create_field_pages( $key, $out = "" ) {
			$out .= '<p>' . $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '</p>';
			$out .= '<select id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" ';
			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}
			$out .= '> ';
			$selected = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];
			$pages = get_pages( 'sort_column=post_parent,menu_order' );
			foreach ( $pages as $page ) {
				$out .= '<option value="' . esc_attr__( $page->ID ) . '" ';
				if ( esc_attr( $selected ) == $page->ID ) {
					$out .= ' selected="selected" ';
				}
				$out .= '>' . esc_html( $page->post_title ) . '</option>';
			}
			$out .= ' </select> ';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<p class="description"><small>' . esc_html( $key[ 'desc' ] ) . '</small></p>';
			}
			return $out;
		}

		/**
		 * Post Select from spesific taxonomy
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.6-enhancements
		 */
		function create_field_posttype( $key, $out = "" ) {
			$out .= '<p>' . $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '</p>';
			$out .= '<select size="1" id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" ';
			if ( isset( $key[ 'class' ] ) ) {
				$out .= 'class="' . esc_attr( $key[ 'class' ] ) . '" ';
			}
			$out .= '> ';
			$selected = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];
			$args = array(
				'post_type' => $key[ 'posttype' ],
				'order' => 'ASC',
				'orderby' => 'title',
				'posts_per_page' => -1,
			);
			$options_posts_obj = get_posts( $args );
			foreach ( $options_posts_obj as $field_ID ) {
				$out .= '<option value="' . esc_attr__( $field_ID->ID ) . '" ';
				if ( esc_attr( $selected ) == $field_ID->ID ) {
					$out .= ' selected="selected" ';
				}
				$out .= '>' . esc_html( $field_ID->post_title ) . '</option>';
			}
			$out .= ' </select> ';

			if ( isset( $key[ 'desc' ] ) ) {
				$out .= '<p class="description"><small>' . esc_html( $key[ 'desc' ] ) . '</small></p>';
			}
			return $out;
		}

		/**
		 * Field Hidden Input
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.6-enhancements
		 */
		function create_field_hidden( $key, $out = "" ) {
			$out .= '<input type="hidden" ';
			$value = isset( $key[ 'value' ] ) ? $key[ 'value' ] : $key[ 'std' ];
			$out .= 'id="' . esc_attr( $key[ '_id' ] ) . '" name="' . esc_attr( $key[ '_name' ] ) . '" value="' . esc_attr__( $value ) . '" ';
			$out .= ' />';
			return $out;
		}
		
		/**
		 * Field Hidden Input
		 *  
		 * @access   private
		 * @param    array
		 * @param    string
		 * @return   string
		 * @since    1.6-enhancements
		 */
		function create_field_heading( $key, $out = "" ) {
			$out .= '<h4>' . $this->create_field_label( $key[ 'name' ], $key[ '_id' ] ) . '</h4><hr>';
			return $out;
		}

	}

}