#include <pebble.h>
#include "netdownload.h"
#include "pixebble.h"

static Window *window;
static TextLayer *text_layer;
static TextLayer *text_layer_pixebble;
static BitmapLayer *bitmap_layer;
static GBitmap *current_bmp;
static BitmapLayer *bitmap_layer_loading;
static GBitmap *s_loading_bitmap;

static char baseLink[] = "http://marcteyssier.com/data/pixebble/data/uploads/";
char *username = "NONE";
static char extension[] = ".png";

void show_next_image() {
  set_user_name();
  
  bitmap_layer_set_bitmap(bitmap_layer, NULL);
  text_layer_set_text(text_layer, "Loading...");

  if (current_bmp) {
    gbitmap_destroy(current_bmp);
    current_bmp = NULL;
  }

  char newUrl[strlen(baseLink)+strlen(username)+strlen(extension)+3];
  //printf("%s", baseLink);
  //printf("%s", username);
  //printf("%s", extension);
  strcpy(newUrl, baseLink);
  strcat(newUrl, username);
  strcat(newUrl, extension);
  
  netdownload_request(newUrl);
}

static void window_load(Window *window) {
  Layer *window_layer = window_get_root_layer(window);
  GRect bounds = layer_get_bounds(window_layer);

  text_layer = text_layer_create((GRect) { .origin = { 0, 130 }, .size = { bounds.size.w, 20 } });
  text_layer_set_text(text_layer, "Refresh it!");
  text_layer_set_text_alignment(text_layer, GTextAlignmentCenter);
  layer_add_child(window_layer, text_layer_get_layer(text_layer));

  text_layer_pixebble = text_layer_create((GRect) { .origin = { 0, 20 }, .size = { bounds.size.w, 20 } });
  text_layer_set_text(text_layer_pixebble, "PIXEBBLE");
  text_layer_set_text_alignment(text_layer_pixebble, GTextAlignmentCenter);
  layer_add_child(window_layer, text_layer_get_layer(text_layer_pixebble));

  s_loading_bitmap = gbitmap_create_with_resource(RESOURCE_ID_PEBBLE_LOADING);

  bitmap_layer_loading = bitmap_layer_create(bounds);
  bitmap_layer_set_bitmap(bitmap_layer_loading, s_loading_bitmap);
  bitmap_layer_set_alignment(bitmap_layer_loading, GAlignCenter);
  layer_add_child(window_layer, bitmap_layer_get_layer(bitmap_layer_loading));

  bitmap_layer = bitmap_layer_create(bounds);
  layer_add_child(window_layer, bitmap_layer_get_layer(bitmap_layer));
  bitmap_layer_loading = bitmap_layer_create(bounds);
  current_bmp = NULL;
 
}

static void window_unload(Window *window) {
  text_layer_destroy(text_layer);
  text_layer_destroy(text_layer_pixebble);
  bitmap_layer_destroy(bitmap_layer);
  bitmap_layer_destroy(bitmap_layer_loading);
  gbitmap_destroy(current_bmp);
  gbitmap_destroy(s_loading_bitmap);
}

void download_complete_handler(NetDownload *download) {
  printf("Loaded image with %lu bytes", download->length);
  printf("Heap free is %u bytes", heap_bytes_free());

  GBitmap *bmp = gbitmap_create_from_png_data(download->data, download->length);
  bitmap_layer_set_bitmap(bitmap_layer, bmp);

  // Save pointer to currently shown bitmap (to free it)
  if (current_bmp) {
    gbitmap_destroy(current_bmp);
  }
  current_bmp = bmp;

  // Free the memory now
  free(download->data);

  // We null it out now to avoid a double free
  download->data = NULL;
  netdownload_destroy(download);
}

void set_user_name() {
 if(persist_exists(USER_NAME)) {
    persist_read_string(USER_NAME, username, 20);
  }
}

static void select_click_handler(ClickRecognizerRef recognizer, void *context) {
  show_next_image();
}

void tap_handler(AccelAxisType accel, int32_t direction) {
  show_next_image();
}

static void click_config_provider(void *context) {
  window_single_click_subscribe(BUTTON_ID_SELECT, select_click_handler);
}

static void init(void) {
  // Need to initialize this first to make sure it is there when
  // the window_load function is called by window_stack_push.
  netdownload_initialize(download_complete_handler);

  window = window_create();
  window_set_window_handlers(window, (WindowHandlers) {
    .load = window_load,
    .unload = window_unload,
  });
  window_stack_push(window, true);

  accel_tap_service_subscribe(tap_handler);
  window_set_click_config_provider(window, click_config_provider);
  set_user_name();
  
}

static void deinit(void) {
  netdownload_deinitialize(); // call this to avoid 20B memory leak
  window_destroy(window);
}

int main(void) {
  init();
  app_event_loop();
  deinit();
}