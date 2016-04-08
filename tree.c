#include "tree.h"
#include <stdio.h>
#include <stdlib.h>

struct tree_node {
  int value;
  struct tree_node *left;
  struct tree_node *right;
};

struct tree_node* new_node(int value){
	struct tree_node *new = malloc(sizeof(struct tree_node));
	new->value = value;
	new->left = new->right = NULL;
	return new;
}

void tree_create(struct tree *self) {
	self->root = NULL;
}

void tree_node_destroy(struct tree_node *self){
	if(self)
	{
		tree_node_destroy(self->left);
		tree_node_destroy(self->right);
		free(self);
	}
}

void tree_destroy(struct tree *self) {
	if(!self || !self->root)
    {
    	return;
    }

  tree_node_destroy(self->root);
}

bool tree_node_contains(const struct tree_node *self, int value) {
	if(!self)
	{
		return false;
	}

  	if(self->value == value)
	{
		return true;
	}

	if(value < self->value)
	{
		return tree_node_contains(self->left, value);
	}

	return tree_node_contains(self->right, value);
}

bool tree_contains(const struct tree *self, int value) {
	if(self)
	{
		return tree_node_contains(self->root, value);
	}
		
  return false;
}

struct tree_node *tree_node_insert(struct tree_node *self, int value){
	if(!self)
	{
		return new_node(value);
	}

	if(value < self->value)
	{
		self->left = tree_node_insert(self->left, value);
    	return self;
	}

  	if(value > self->value)
  	{
		self->right = tree_node_insert(self->right, value);
    	return self;
	}
  	return self;
}

void tree_insert(struct tree *self, int value) {
	if(self)
    {
    	self->root = tree_node_insert(self->root, value);
    }
}

struct tree_node *tree_node_delete_min(struct tree_node *self, struct tree_node **min){
	if(!self->left)
	{
		struct tree_node *right = self->right;
		self->right = NULL;
		*min = self;
		return right;
	}
	self->left = tree_node_delete_min(self->left, min);
	return self;
}

struct tree_node *tree_node_delete(struct tree_node *self){
	struct tree_node *left = self->left;
	struct tree_node *right = self->right;
	free(self);
	self = NULL;
	if(!left && !right)
	{
		return NULL;
	}

	if (!left)
	{
		return right;
	}

	if(!right)
	{
		return left;
	}

	right = tree_node_delete_min(right, &self);
	self->left = left;
	self->right = right;
	return self;
}

struct tree_node *tree_node_remove(struct tree_node *self, int value){
	if(!self)
	{
		return NULL;
	}

	if(value < self->value){
		self->left = tree_node_remove(self->left, value);
		return self;
	}

	if(value > self->value){
		self->right = tree_node_remove(self->right, value);
		return self;
	}

	return tree_node_delete(self);
}

void tree_remove(struct tree *self, int value) {
	if(self)
	{
		self->root = tree_node_remove(self->root, value);
	}
}

bool tree_is_empty(const struct tree *self) {
  	return tree_size(self) == 0;
}

size_t tree_node_size(const struct tree_node *self){
	if(!self)
	{
		return 0;
	}
	return tree_node_size(self->left) + 1 +tree_node_size(self->right);
	
}

size_t tree_size(const struct tree *self) {
    if(self)
	{
		return tree_node_size(self->root);
	}
	return 0;
}

size_t tree_node_height(const struct tree_node *self){
	if(!self)
	{
		return 0;
	}

	int leftHeight = tree_node_height(self->left);
	int rightHeight = tree_node_height(self->right);

	if (leftHeight > rightHeight)
	{
		return leftHeight + 1;
	}
	else
	{
		return rightHeight + 1;
	}
}

size_t tree_height(const struct tree *self) {
	if(self)
	{
		return tree_node_height(self->root);
	}
 	return 0;
}

void tree_node_walk_pre_order(const struct tree_node *self, tree_func_t func, void *user_data) {
  if(!self)
	{
		return;
	}
  func(self->value, user_data);
  tree_node_walk_pre_order(self->left, func, user_data);
  tree_node_walk_pre_order(self->right, func, user_data);
}

void tree_walk_pre_order(const struct tree *self, tree_func_t func, void *user_data)  {
	if(self)
	{
		tree_node_walk_pre_order(self->root, func, user_data);
	}
}

void tree_node_walk_in_order(const struct tree_node *self, tree_func_t func, void *user_data) {
  if(!self)
	{
		return;
	}
  tree_node_walk_in_order(self->left, func, user_data);
  func(self->value, user_data);
  tree_node_walk_in_order(self->right, func, user_data);
}

void tree_walk_in_order(const struct tree *self, tree_func_t func, void *user_data) {
 if(self)
  {
  	tree_node_walk_in_order(self->root, func, user_data);
  }
}

void tree_node_walk_post_order(const struct tree_node *self, tree_func_t func, void *user_data) {
  if(!self)
	{
		return;
	}
  tree_node_walk_post_order(self->left, func, user_data);
  tree_node_walk_post_order(self->right, func, user_data);
  func(self->value, user_data);
}

void tree_walk_post_order(const struct tree *self, tree_func_t func, void *user_data) {
  if(self)
  {
  	tree_node_walk_post_order(self->root, func, user_data);
  }
}

void tree_node_dump(const struct tree_node *self){
	
}
void tree_dump(const struct tree *self) {
	if (self)
	{
		printf("[");
		tree_node_dump(self->root);
    	printf("]\n");
	}
}
